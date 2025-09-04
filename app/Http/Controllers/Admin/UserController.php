<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('role');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('role', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Sort by latest
        $query->orderBy('created_at', 'desc');

        $users = $query->paginate(10)->withQueryString();
        $roles = Role::all();

        return view('admin.user.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'nik' => 'nullable|string|size:16|unique:users',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        User::create($validated);

        return redirect()->route('admin.user.index')
                        ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('role', 'suratProcessed', 'antrianServed', 'berita', 'pengaduanHandled');
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'nik' => ['nullable', 'string', 'size:16', Rule::unique('users')->ignore($user->id)],
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'is_active' => 'boolean',
        ]);

        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.user.index')
                        ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting current user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')
                            ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        // Check if user has related data
        $hasRelatedData = $user->suratProcessed()->exists() || 
                         $user->antrianServed()->exists() || 
                         $user->berita()->exists() || 
                         $user->pengaduanHandled()->exists();

        if ($hasRelatedData) {
            return redirect()->route('admin.user.index')
                            ->with('error', 'User tidak dapat dihapus karena memiliki data terkait.');
        }

        $user->delete();

        return redirect()->route('admin.user.index')
                        ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus(User $user)
    {
        // Prevent deactivating current user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')
                            ->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('admin.user.index')
                        ->with('success', "User berhasil {$status}.");
    }

    /**
     * Reset user password.
     */
    public function resetPassword(User $user)
    {
        $newPassword = 'password123';
        
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return redirect()->route('admin.user.show', $user)
                        ->with('success', "Password user berhasil direset. Password baru: {$newPassword}");
    }
}