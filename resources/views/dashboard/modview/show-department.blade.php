<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $department->name }}
        </h2>
    </x-slot>
    <div class="m-4 p-4 flex flex-col items-center gap-4 w-auto">
        <div
            class="bg-white shadow-lg rounded-lg p-6 border border-gray-200 hover:shadow-xl transition flex flex-col 
               w-5/6">
            <p class="text-gray-600 text-sm mb-4">{{ $department->description }}</p>
        </div>
    </div>
</x-app-layout>
