<x-app-layout :navigation="Auth::user()->hasRole('supervisor') ? 'layouts.navigation_spv' : 'layouts.navigation'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            List Departemen
        </h2>
    </x-slot>
    <div class="m-4 p-4 flex flex-col items-center gap-4 w-auto">
        @forelse ($departments as $department)
            <div
                class="bg-white shadow-lg rounded-lg p-6 border border-gray-200 hover:shadow-xl transition flex flex-col 
               w-[350px] sm:w-[380px] md:w-[400px] lg:w-2/4">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $department->name }}</h2>
                @if ($department->managing_director)
                    <p class="text-gray-600 text-sm mb-1">Managing Director : {{ $department->managing_director->name }}
                        | {{ $department->managing_director->email }}</p>
                @else
                    <p class="text-gray-600 text-sm mb-1">Managing Director : - </p>
                @endif
                <p class="text-gray-600 text-sm mb-4">Total Program Kerja : {{ $department->work_programs_count }}
                </p>
                <div class="mt-auto">
                    <a href="{{ route('dashboard.modview.department.show', ['department' => $department]) }}"
                        class="inline-block text-blue-600 font-semibold hover:underline">
                        Selengkapnya →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 flex justify-center items-center h-40">
                <p class="text-gray-500 text-lg font-semibold">No data available.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
