<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-row items-center">
            <div class="text-[11px] text-gray-500 font-medium md:text-sm">
                <nav class="flex items-center space-x-1 md:space-x-2">
                    <a href="{{ route('dashboard.workProgram.index', ['department' => $workProgram->department]) }}"
                        class="hover:underline hover:text-[#111B5A] cursor-pointer">
                        Program Kerja
                    </a>
                    <span class="text-gray-400">/</span>
                    <a href="{{ route('dashboard.workProgram.index', ['department' => $workProgram->department]) }}"
                        class="hover:underline hover:text-[#111B5A] cursor-pointer">
                        {{ $workProgram->department->name }}
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-800 font-semibold">
                        {{ $workProgram->name }}
                    </span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="relative max-w-[90dvw] mx-auto px-6 py-2 rounded-lg">
        <h1 class="bg-white p-6 rounded-xl shadow-md border border-gray-200 text-3xl font-bold text-[#111B5A] ">
            {{ $workProgram->name }}</h1>


        @include('components.sweet-alert')

        @php
            $infoItems = [
                'Deskripsi' => $workProgram->description,
                'Periode' => $workProgram->timeline_range_text,
                'Dana' => 'Rp ' . number_format($workProgram->funds, 0, ',', '.'),
                'Sumber Dana' => $workProgram->sources_of_funds,
                'Total Partisipasi' => $workProgram->participation_total . ' Orang',
                'Cakupan Partisipasi' => $workProgram->participation_coverage,
            ];

            $files = [
                'LPJ' => $workProgram->lpj_url,
                'SPG' => $workProgram->spg_url,
            ];
        @endphp

        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 mt-4">
            <div class="flex flex-col justify-center">

                <h2 class="text-2xl font-bold text-[#111B5A]  mb-2">📋 Informasi Program Kerja</h2>
                <p class="text-[10px] text-gray-400 italic mb-2 ml-2">id: {{ $workProgram->id }}</p>
            </div>

            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 md:gap-6">
                @foreach ($infoItems as $label => $value)
                    <div class="p-4 bg-blue-50/50 rounded-lg border border-blue-100/70 shadow-sm">
                        <p class="text-[16px] md:text-md  font-semibold text-[#14267B] mb-1">{{ $label }}</p>
                        <p class="text-[12px] md:text-sm text-gray-600  {{ $label === 'Dana' ? 'font-semibold' : '' }}">
                            {{ $value }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white mt-4 p-6 rounded-xl shadow-md border border-gray-200">
            <h2 class="text-2xl font-bold text-[#111B5A]  mb-4">📂 Dokumen Terkait</h2>

            <div class="space-y-3 md:space-y-4">
                @foreach ($files as $label => $url)
                    @if ($url)
                        <div
                            class="flex items-center justify-between p-4 bg-blue-50/50 rounded-lg border border-blue-100/70  rounded-lg">
                            <div>
                                <p class="text-[16px] md:text-md text-[#14267B] font-semibold">File {{ $label }}
                                </p>
                                <p class="text-[12px] md:text-sm italic text-gray-600">{{ explode('/', $url)[1] }}</p>
                            </div>
                            <a href="{{ route('pdf.show', ['filename' => explode('/', $url)[1]]) }}" target="_blank"
                                class="text-sm px-4 py-2 text-white bg-[#111B5A] hover:bg-[#14267B] rounded-md transition">
                                📄 Lihat / Unduh
                            </a>
                        </div>
                    @else
                        <div class="p-4 bg-red-100 border border-red-300 rounded-lg">
                            <p class="text-[16px] md:text-md text-red-700 font-medium">File {{ $label }}</p>
                            <p class="text-[12px] md:text-sm text-gray-800">File {{ $label }} belum diunggah</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>


        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 mt-4">
            <div class="mt-2">
                <h3 class="text-2xl font-bold text-[#111B5A] mb-4">💬 Diskusi & Komentar</h3>

                @if ($workProgram->comments->isNotEmpty())
                    <ul class="space-y-2">
                        @foreach ($workProgram->comments as $comment)
                            <div class="rounded-lg p-2">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-lg text-[#14267B] font-semibold">
                                            {{ $comment->author->name }}
                                            <span class="text-sm text-gray-400 font-normal"> •
                                                {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                        </p>
                                        <div class="trix-content font-normal text-gray-600 mt-2">{!! $comment->content !!}
                                        </div>
                                        <p class="text-xs text-gray-400 mt-2">{{ $comment->created_at }}</p>
                                    </div>

                                    @if (Auth::id() === $comment->user_id)
                                        <form method="POST"
                                            action="{{ route('dashboard.workProgram.comment.destroy', ['workProgram' => $workProgram, 'comment' => $comment]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Komentar"
                                                class="text-red-400 hover:text-red-500 italic text-sm transition duration-200 ease-in-out">
                                                Delete
                                            </button>
                                        </form>
                                    @endif

                                </div>
                                <div class="h-[1px] mt-3 bg-gray-200 w-full"></div>
                            </div>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600">Belum ada komentar atau catatan.</p>
                @endif
            </div>

            <div class="mt-2 p-2">
                <h4 class="text-xl font-bold text-[#111B5A] mb-4">📝 Tambah Komentar</h4>

                <form method="POST"
                    action="{{ route('dashboard.workProgram.comment.store', ['workProgram' => $workProgram]) }}">
                    @csrf
                    <input id="content" type="hidden" name="content">
                    <trix-editor input="content"
                        class="trix-content w-full h-32 bg-gray-100 border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-gray-300"></trix-editor>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="mt-2 text-sm px-4 py-2 text-white bg-[#111B5A] hover:bg-[#14267B] rounded-md transition">
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-md border border-gray-200 mt-4 flex flex-col gap-2 md:flex-row md:justify-between">

            <a href="{{ route('dashboard.workProgram.index', ['department' => $workProgram->department]) }}"
                class="px-4 py-2 bg-gray-300 text-[#111B5A] font-semibold rounded-lg shadow-sm hover:bg-gray-200 transition-all duration-200 flex items-center gap-1">
                ← Kembali
            </a>

            <div class="flex gap-2">
                <a href="{{ route('dashboard.workProgram.edit', ['workProgram' => $workProgram, 'department' => $workProgram->department]) }}"
                    class="text-center w-48 px-4 py-2 bg-[#111B5A] text-white font-semibold rounded-lg shadow-sm hover:bg-[#14267B] transition-all duration-200">
                    ✏️ Edit Program
                </a>

                <form
                    action="{{ route('dashboard.workProgram.destroy', ['workProgram' => $workProgram, 'department' => $workProgram->department]) }}"
                    method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-center w-48 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-sm hover:bg-red-500 transition-all duration-200">
                        🗑️ Hapus Program
                    </button>
                </form>
            </div>
        </div>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
</x-app-layout>
