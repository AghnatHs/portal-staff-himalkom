<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Program Kerja - {{ $workProgram->department->name }} - "{{ $workProgram->name }}"
        </h2>
    </x-slot>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">

        <h1 class="text-3xl font-bold text-gray-800 mb-0">{{ $workProgram->name }}</h1>
        <p class="text-xs">id: {{ $workProgram->id }}</p>

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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Deskripsi:</p>
                <p class="text-gray-800">{{ $workProgram->description }}</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Periode:</p>
                <p class="text-gray-800">{{ $workProgram->timeline_range_text }}</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Dana:</p>
                <p class="text-gray-800 font-semibold">Rp {{ number_format($workProgram->funds, 0, ',', '.') }}</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Sumber Dana:</p>
                <p class="text-gray-800">{{ $workProgram->sources_of_funds }}</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Total Partisipasi:</p>
                <p class="text-gray-800">{{ $workProgram->participation_total }} Orang</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Cakupan Partisipasi:</p>
                <p class="text-gray-800">{{ $workProgram->participation_coverage }}</p>
            </div>

        </div>
        @if ($workProgram->lpj_url)
            <div class="bg-gray-100 p-4 rounded-lg my-2">
                <p class="text-sm text-gray-600">File LPJ:</p>
                <a class="text-red-700 hover:text-red-500"
                    href="{{ route('pdf.show', ['filename' => explode('/', $workProgram->lpj_url)[1]]) }}"
                    target="_blank">View or
                    Download File</a>
                <p class="text-xs text-gray-800">({{ explode('/', $workProgram->lpj_url)[1] }})</p>
            </div>
        @else
            <div class="bg-red-200 p-4 rounded-lg my-2">
                <p class="text-sm text-gray-600">File LPJ:</p>
                <p class="text-gray-800">File LPJ belum diunggah</p>
            </div>
        @endif

        @if ($workProgram->spg_url)
            <div class="bg-gray-100 p-4 rounded-lg my-2">
                <p class="text-sm text-gray-600">File SPG:</p>
                <a class="text-red-700 hover:text-red-500"
                    href="{{ route('pdf.show', ['filename' => explode('/', $workProgram->spg_url)[1]]) }}"
                    target="_blank">View or
                    Download File</a>
                <p class="text-xs text-gray-800">({{ explode('/', $workProgram->spg_url)[1] }})</p>
            </div>
        @else
            <div class="bg-red-200 p-4 rounded-lg my-2">
                <p class="text-sm text-gray-600">File SPG:</p>
                <p class="text-gray-800">File SPG belum diunggah</p>
            </div>
        @endif


        <div class="mt-6 flex justify-between">
            <a href="{{ route('dashboard.workProgram.index', ['department' => $workProgram->department]) }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                ← Kembali
            </a>

            <a href="{{ route('dashboard.workProgram.edit', ['workProgram' => $workProgram, 'department' => $workProgram->department]) }}"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                Edit Program
            </a>
            <form
                action="{{ route('dashboard.workProgram.destroy', ['workProgram' => $workProgram, 'department' => $workProgram->department]) }}"
                method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Hapus Program
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
