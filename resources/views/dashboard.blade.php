<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-4 md:px-4 lg:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-xl">
                    You're logged in!
                </div>
                <div class="p-6 text-gray-900 text-xl">
                    Hallo {{ Auth::user()->name }} | {{ Auth::user()->email }}
                </div>

                @hasrole('managing director')
                    <div class="p-6 text-gray-900 text-xl">
                        {{ Auth::user()->pluckRoleName('managing director') }} of
                        {{ Auth::user()->department->name }}
                    </div>
                @else
                @endhasrole
            </div>
</x-app-layout>
