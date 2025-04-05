<x-app-layout :navigation="Auth::user()->hasRole('supervisor') ? 'layouts.navigation-spv' : 'layouts.navigation'">
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

        @php
            $successData = session('success');
        @endphp

        @if ($successData)
            <script>
                const successId = sessionStorage.getItem('success_id');
                const currentSuccessId = @json($successData['id']);

                if (!successId || successId !== currentSuccessId) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: @json($successData['message']),
                        confirmButtonText: 'OK'
                    }).then(() => {
                        sessionStorage.setItem('success_id', currentSuccessId);
                        fetch("{{ route('session.clear', 'success') }}");
                    });
                }
            </script>
        @endif


        @php
            $errorData = session('error');
        @endphp

        @if ($errorData)
            <script>
                const errorId = sessionStorage.getItem('error_id');
                const currentErrorId = @json($errorData['id']);

                if (!errorId || errorId !== currentErrorId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: @json($errorData['message']),
                        confirmButtonText: 'OK'
                    }).then(() => {
                        sessionStorage.setItem('error_id', currentErrorId);
                        fetch("{{ route('session.clear', 'error') }}");
                    });
                }
            </script>
        @endif

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

        @if ($workProgram->comments->isNotEmpty())
            <div class="mt-2 bg-white rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Komentar</h3>
                <ul class="space-y-4">
                    @foreach ($workProgram->comments as $comment)
                        <li class="border rounded-lg p-4 flex justify-between items-center bg-gray-50">
                            <div>
                                <small class="text-gray-500 block">{{ $comment->author->name }} -
                                    {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                                <div class="trix-content text-gray-700 mb-2">{!! $comment->content !!}</div>
                                <small class="text-gray-400 block">{{ $comment->created_at }}</small>
                            </div>
                            @if (Auth::user()->id === $comment->user_id)
                                <form method="POST"
                                    action="{{ route('dashboard.workProgram.comment.destroy', ['workProgram' => $workProgram, 'comment' => $comment]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 text-sm hover:text-red-700">Hapus</button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-gray-50 p-4 rounded-lg my-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Komentar</h3>
                <p class="text-gray-600">Belum ada komentar.</p>
            </div>
        @endif

        <form method="POST"
            action="{{ route('dashboard.workProgram.comment.store', ['workProgram' => $workProgram]) }}"
            class="mt-2 bg-white rounded-lg p-6">
            @csrf

            <input id="content" type="hidden" name="content">
            <trix-editor input="content"
                class="trix-content w-full h-32 bg-gray-100 border rounded-lg p-2"></trix-editor>

            <button type="submit"
                class="mt-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition">
                Tambah Komentar
            </button>
        </form>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
</x-app-layout>
