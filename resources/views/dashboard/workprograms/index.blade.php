<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Program Kerja - {{ $department->name }}
        </h2>
    </x-slot>
    <div class="max-w-6xl mx-auto py-2 px-2">

        <script>
            @if ($message = session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: @json(session('success')),
                    confirmButtonText: 'OK'
                });
            @endif
        </script>

        <script>
            @if ($message = session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    confirmButtonText: 'Coba Lagi'
                });
            @endif
        </script>

        <div class="flex justify-end mb-3">
            <a href="{{ route('dashboard.workProgram.create', ['department' => $department]) }}"
                class="mr-2 lg:mr-0 bg-green-600 text-white px-2 py-1 md:px-4 md:py-2 rounded-lg shadow hover:bg-green-800 transition text-md md:text-lg">
                Tambah Program Kerja
            </a>
        </div>

        <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 lg:gap-4">
            @forelse ($department->workPrograms as $workProgram)
            <div class="mx-2 lg:mx-0 bg-white shadow-md rounded-[10px] p-4 border border-gray-200 hover:shadow-lg transition flex flex-col">
                <h2 class="uppercase text-lg md:text-xl font-bold text-gray-900">{{ $workProgram->name }}</h2>
                <p class="text-[10px] mb-2">id: {{ $workProgram->id }}</p>
                
                <div class="my-1 md:my-2">
                    <h3 class="text-sm font-semibold text-gray-700">Description</h3>
                    <p class="text-gray-600 text-sm my-1 md:my-2 break-words">{{ Str::limit($workProgram->description, 100, '...') }}</p>
                    <hr class="border-t border-gray-200 my-2">
                </div>
                
                <div class="my-1 md:my-2">
                    <h3 class="text-sm font-semibold text-gray-700">Timeline</h3>
                    @php
                        $diffInDays = \Carbon\Carbon::parse($workProgram->start_at)->diffInDays(
                            \Carbon\Carbon::parse($workProgram->finished_at),
                        );
                    @endphp
                    <p class="text-gray-500 text-[12px] my-1">{{ $workProgram->timeline_range_text }}</p>
                    <hr class="border-t border-gray-200 my-2">
                </div>
            
                <div class="my-1 md:my-2">
                    <h3 class="text-sm font-semibold text-gray-700">Last Updated</h3>
                    <p class="text-gray-500 text-[12px]">{{ \Carbon\Carbon::parse($workProgram->created_at)->diffForHumans() }}</p>
                    <hr class="border-t border-gray-200 my-2">
                </div>

                <div class="mt-1 md:mt-2">
                    <a href="{{ route('dashboard.workProgram.detail', ['workProgram' => $workProgram, 'department' => $department]) }}"
                        class="inline-block text-blue-500 text-xs font-semibold hover:underline">
                        Read More →
                    </a>
                </div>
            </div>
            
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 flex justify-center items-center h-40">
                    <p class="text-gray-500 text-lg font-semibold">No data available.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
