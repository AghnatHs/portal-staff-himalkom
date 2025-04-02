<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.modview.department.index') }}" class="text-gray-600 hover:text-black">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $department->name }}
            </h2>
        </div>
    </x-slot>
    <div class="m-4 p-2 flex flex-col items-center gap-4 w-auto">
        <div
            class="bg-white shadow-lg rounded-lg p-4 border border-gray-200 hover:shadow-xl transition flex flex-col w-full lg:w-5/6">
            <p class="text-gray-800 text-base">Managing Director</p>
            @if ($department->managing_director)
                <p class="text-gray-600 text-sm">
                    {{ $department->managing_director->name }} | {{ $department->managing_director->email }}</p>
            @else
                <p class="text-gray-600 text-sm mb-1">-</p>
            @endif
        </div>
        <div
            class="bg-white shadow-lg rounded-lg p-6 border border-gray-200 hover:shadow-xl transition flex flex-col w-full lg:w-5/6">
            <p class="text-gray-800 text-base">Deskripsi</p>
            <p class="text-gray-600 text-sm">{{ $department->description }}</p>
        </div>
        <div
            class="bg-white shadow-lg rounded-lg p-4 border border-gray-200 hover:shadow-xl transition flex flex-col w-full lg:w-5/6">
            <p class="text-gray-800 text-base mb-2">Program Kerja</p>
            @forelse ($department->workPrograms as $workProgram)
                <div
                    class="bg-gray-100 shadow-lg rounded-lg p-6 mb-2 border border-gray-200 hover:shadow-xl transition flex flex-col w-full">
                    <h1 class="text-sm font-bold text-gray-800 mb-0 w-1/2">{{ $workProgram->name }}</h1>
                    <h2 class="text-xs font-bold text-gray-800 mb-0 w-1/2">{{ $workProgram->timeline_range_text }}</h2>
                    <a href="{{ route('dashboard.modview.workprogram.show', ['department' => $department, 'workProgram' => $workProgram]) }}"
                        class="inline-block text-blue-600 font-semibold hover:underline text-xs">
                        Selengkapnya →
                    </a>
                </div>
            @empty
                <h1 class="text-sm font-bold text-gray-800 mb-0 w-1/2">No data available.</h1>
            @endforelse
        </div>
    </div>
</x-app-layout>
