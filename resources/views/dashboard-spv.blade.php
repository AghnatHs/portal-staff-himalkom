<x-app-layout navigation='layouts.navigation-spv'>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white shadow rounded-lg p-6 sm:p-8">
                {{-- Greeting Message --}}
                <div class="flex items-center space-x-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Hallo, {{ Auth::user()->name }} 👋</h1>
                        <p class="mt-1 text-gray-600 text-lg">Welcome back to your dashboard!</p>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="mt-10">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Links</h2>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <a href="{{ route('dashboard.notifications.index') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg py-3 text-center font-medium transition">
                            Notifications
                        </a>

                        <a href="{{ route('dashboard.modview.department.index') }}"
                            class="bg-green-600 hover:bg-green-700 text-white rounded-lg py-3 text-center font-medium transition">
                            Supervisi Department
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white rounded-lg py-3 text-center font-medium transition">
                            Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
