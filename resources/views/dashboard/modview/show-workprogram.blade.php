<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.modview.department.show', ['department' => $workProgram->department]) }}"
                class="text-gray-600 hover:text-black">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $workProgram->department->name }} - "{{ $workProgram->name }}"
            </h2>
        </div>
    </x-slot>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">

        <h1 class="text-3xl font-bold text-gray-800 mb-0">{{ $workProgram->name }}</h1>
        <p class="text-xs"> Departemen: {{ $workProgram->department->name }}</p>

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

    </div>
</x-app-layout>
