<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Log Aktivitas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Filter -->
                    <form method="GET" action="{{ route('admin.activity-logs') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <select name="action" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                                    <option value="">Semua Aksi</option>
                                    <option value="user_login" {{ request('action') == 'user_login' ? 'selected' : '' }}>Login</option>
                                    <option value="user_logout" {{ request('action') == 'user_logout' ? 'selected' : '' }}>Logout</option>
                                    <option value="user_created" {{ request('action') == 'user_created' ? 'selected' : '' }}>Buat Pengguna</option>
                                    <option value="user_updated" {{ request('action') == 'user_updated' ? 'selected' : '' }}>Update Pengguna</option>
                                    <option value="user_deleted" {{ request('action') == 'user_deleted' ? 'selected' : '' }}>Hapus Pengguna</option>
                                    <option value="citizen_created" {{ request('action') == 'citizen_created' ? 'selected' : '' }}>Buat Penduduk</option>
                                    <option value="citizen_updated" {{ request('action') == 'citizen_updated' ? 'selected' : '' }}>Update Penduduk</option>
                                    <option value="citizen_deleted" {{ request('action') == 'citizen_deleted' ? 'selected' : '' }}>Hapus Penduduk</option>
                                    <option value="citizens_imported" {{ request('action') == 'citizens_imported' ? 'selected' : '' }}>Import Penduduk</option>
                                </select>
                            </div>
                            <div>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                            </div>
                            <div>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Cari
                            </button>
                            <a href="{{ route('admin.activity-logs') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                Reset
                            </a>
                        </div>
                    </form>

                    <!-- Activity Logs Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pengguna
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        IP Address
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($activityLogs as $log)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-xs font-medium text-gray-700">
                                                            {{ $log->user ? strtoupper(substr($log->user->name, 0, 2)) : 'SY' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $log->user ? $log->user->name : 'System' }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $log->user ? $log->user->role : 'system' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $actionColors = [
                                                    'user_login' => 'bg-green-100 text-green-800',
                                                    'user_logout' => 'bg-gray-100 text-gray-800',
                                                    'user_created' => 'bg-blue-100 text-blue-800',
                                                    'user_updated' => 'bg-yellow-100 text-yellow-800',
                                                    'user_deleted' => 'bg-red-100 text-red-800',
                                                    'citizen_created' => 'bg-blue-100 text-blue-800',
                                                    'citizen_updated' => 'bg-yellow-100 text-yellow-800',
                                                    'citizen_deleted' => 'bg-red-100 text-red-800',
                                                    'citizens_imported' => 'bg-purple-100 text-purple-800',
                                                ];
                                                $colorClass = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $colorClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $log->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->ip_address }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada log aktivitas ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $activityLogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>