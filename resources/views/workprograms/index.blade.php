<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Program Kerja - {{ $department->name }}
        </h2>
    </x-slot>
    <div class="max-w-6xl mx-auto py-8 px-4">

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

        <div class="flex justify-center mb-6">
            <a href="{{ route('dashboard.workProgram.create', ['department' => $department]) }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                Tambah Program Kerja
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($department->workPrograms as $workProgram)
                <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200 hover:shadow-xl transition">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $workProgram->name }}</h2>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($workProgram->description, 100, '...') }}</p>
                    <p class="text-gray-500 text-sm mb-4">{{ $workProgram->start_at }} - {{ $workProgram->finished_at }}
                    </p>
                    <a href="{{ route('dashboard.workProgram.detail', ['workProgram' => $workProgram, 'department' => $department]) }}"
                        class="inline-block text-blue-600 font-semibold hover:underline">
                        Selengkapnya →
                    </a>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 flex justify-center items-center h-40">
                    <p class="text-gray-500 text-lg font-semibold">No data available.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
