<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Citizen;
use App\Models\Village;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,pegawai']);
    }

    public function dashboard()
    {
        // Statistik pengguna
        $totalUsers = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalPegawai = User::where('role', 'pegawai')->count();
        $totalMasyarakat = User::where('role', 'masyarakat')->count();
        $activeUsers = User::where('is_active', true)->count();
        
        // Statistik aktivitas hari ini
        $todayLogins = User::whereDate('last_login_at', today())->count();
        
        // Statistik kependudukan
        $totalCitizens = Citizen::active()->count();
        $totalMale = Citizen::active()->byGender('L')->count();
        $totalFemale = Citizen::active()->byGender('P')->count();
        $totalVillages = Village::active()->count();
        
        // Statistik berdasarkan agama
        $religionStats = Citizen::active()
            ->select('religion', DB::raw('count(*) as total'))
            ->groupBy('religion')
            ->pluck('total', 'religion')
            ->toArray();
        
        // Statistik berdasarkan status perkawinan
        $maritalStats = Citizen::active()
            ->select('marital_status', DB::raw('count(*) as total'))
            ->groupBy('marital_status')
            ->pluck('total', 'marital_status')
            ->toArray();
        
        // Statistik berdasarkan kelompok umur
        $ageGroups = [
            '0-17' => Citizen::active()->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 0 AND 17')->count(),
            '18-30' => Citizen::active()->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 18 AND 30')->count(),
            '31-50' => Citizen::active()->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 31 AND 50')->count(),
            '51-65' => Citizen::active()->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 51 AND 65')->count(),
            '65+' => Citizen::active()->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) > 65')->count(),
        ];
        
        // Statistik per desa
        $villageStats = Village::active()
            ->withCount('activeCitizens')
            ->orderBy('active_citizens_count', 'desc')
            ->limit(10)
            ->get();
        
        // Data untuk chart
        $usersByRole = [
            'admin' => $totalAdmin,
            'pegawai' => $totalPegawai,
            'masyarakat' => $totalMasyarakat
        ];
        
        $populationByGender = [
            'Laki-laki' => $totalMale,
            'Perempuan' => $totalFemale
        ];
        
        // Aktivitas login 7 hari terakhir
        $loginStats = User::select(
            DB::raw('DATE(last_login_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('last_login_at', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmin', 
            'totalPegawai',
            'totalMasyarakat',
            'activeUsers',
            'todayLogins',
            'totalCitizens',
            'totalMale',
            'totalFemale',
            'totalVillages',
            'religionStats',
            'maritalStats',
            'ageGroups',
            'villageStats',
            'usersByRole',
            'populationByGender',
            'loginStats'
        ));
    }

    public function users()
    {
        $users = User::with([])
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('employee_id', 'like', "%{$search}%");
            })
            ->when(request('role'), function ($query, $role) {
                $query->where('role', $role);
            })
            ->when(request('status'), function ($query, $status) {
                if ($status === 'active') {
                    $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Recent activity logs
        $recentActivities = ActivityLog::with('user')
            ->recent(7)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // User statistics
        $userStats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'admin' => User::where('role', 'admin')->count(),
            'pegawai' => User::where('role', 'pegawai')->count(),
            'masyarakat' => User::where('role', 'masyarakat')->count(),
            'today_logins' => User::whereDate('last_login_at', today())->count(),
        ];

        return view('admin.users.index', compact('users', 'recentActivities', 'userStats'));
    }

    public function userCreate()
    {
        return view('admin.users.create');
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,pegawai,masyarakat',
            'employee_id' => 'nullable|string|max:50|unique:users',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $userData = $request->only([
            'name', 'email', 'phone', 'role', 'employee_id', 
            'position', 'department'
        ]);
        
        $userData['password'] = Hash::make($request->password);
        $userData['is_active'] = $request->has('is_active');
        $userData['email_verified_at'] = now();

        $user = User::create($userData);

        // Log activity
        ActivityLog::log(
            'user_created',
            "Membuat pengguna baru: {$user->name} ({$user->email})",
            $user,
            ['role' => $user->role, 'employee_id' => $user->employee_id]
        );

        return redirect()->route('admin.users')
            ->with('success', 'Pengguna berhasil dibuat!');
    }

    public function userShow($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function userEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,pegawai,masyarakat',
            'phone' => 'nullable|string|max:20',
            'employee_id' => 'nullable|string|max:20|unique:users,employee_id,' . $id,
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);
        
        $oldData = $user->only(['name', 'email', 'role', 'is_active']);
        
        $user->update($request->only([
            'name', 'email', 'role', 'phone', 'employee_id', 
            'position', 'department', 'is_active'
        ]));
        
        // Log activity
        ActivityLog::log(
            'user_updated',
            "Memperbarui data pengguna: {$user->name}",
            $user,
            ['old_data' => $oldData, 'new_data' => $user->only(['name', 'email', 'role', 'is_active'])]
        );
        
        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function userDestroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        
        // Log activity before deletion
        ActivityLog::log(
            'user_deleted',
            "Menghapus pengguna: {$user->name} ({$user->email})",
            null,
            ['deleted_user' => $user->only(['name', 'email', 'role', 'employee_id'])]
        );
        
        $user->delete();
        
        return redirect()->route('admin.users')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
    
    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('user');
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Action filter
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $activityLogs = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.activity-logs.index', compact('activityLogs'));
    }
}
