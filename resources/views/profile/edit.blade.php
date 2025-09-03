<x-admin-layout>
    <x-slot name="header">
        Profile Saya
    </x-slot>

    <div class="admin-container">
        <!-- Profile Header -->
        <div class="admin-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 rounded-full flex items-center justify-center" style="background-color: #003566;">
                    <span class="text-2xl font-bold text-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold" style="color: #003566;">{{ Auth::user()->name }}</h1>
                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                    <div class="flex items-center mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: #e6f3ff; color: #003566;">
                            <i class="fas fa-user-tag mr-1"></i>
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                        @if(Auth::user()->department)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-2" style="background-color: #f0f9ff; color: #0ea5e9;">
                                <i class="fas fa-building mr-1"></i>
                                {{ Auth::user()->department }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Cards Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 md:gap-6">
            <!-- Update Profile Information -->
            <div class="xl:col-span-2 order-1">
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Sidebar: Password & Delete Account -->
            <div class="xl:col-span-1 order-2 space-y-4 md:space-y-6">
                <!-- Update Password -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Delete Account -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
