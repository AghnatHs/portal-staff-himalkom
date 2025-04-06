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
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-800 font-semibold">
                        Edit
                    </span>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl my-2 mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Edit Program Kerja</h2>
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 border border-red-400">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('dashboard.workProgram.update', ['workProgram' => $workProgram, 'department' => $workProgram->department]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-semibold">Judul Program</label>
                <input type="text" name="name" id="title" value="{{ $workProgram->name }}"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold">Deskripsi</label>
                <textarea name="description" id="description" rows="5"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ $workProgram->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="start_at" class="block text-gray-700 font-semibold">Tanggal Mulai</label>
                <input type="date" name="start_at" id="start_at" value="{{ $workProgram->start_at }}"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="finished_at" class="block text-gray-700 font-semibold">Tanggal Selesai</label>
                <input type="date" name="finished_at" id="finished_at" value="{{ $workProgram->finished_at }}"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="funds" class="block text-gray-700 font-semibold">Dana</label>
                <input type="text" id="funds_display" value="{{ number_format($workProgram->funds, 0, ',', '.') }}"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <input type="hidden" name="funds" id="funds" value="{{ $workProgram->funds }}">
            </div>

            <div class="mb-4">
                <label for="sources_of_funds" class="block text-gray-700 font-semibold">
                    Sumber Dana
                </label>

                <div class="space-y-2">
                    @php
                        $selectedSources = is_array($workProgram->sources_of_funds)
                            ? $workProgram->sources_of_funds
                            : json_decode($workProgram->sources_of_funds, true) ?? [];
                    @endphp


                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="sources_of_funds[]" value="BPPTN"
                            {{ in_array('BPPTN', $selectedSources) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>BPPTN</span>
                    </label>

                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="sources_of_funds[]" value="Dana Sekolah"
                            {{ in_array('Dana Sekolah', $selectedSources) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Dana Sekolah</span>
                    </label>

                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="sources_of_funds[]" value="Mandiri"
                            {{ in_array('Mandiri', $selectedSources) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Mandiri</span>
                    </label>
                </div>
            </div>


            <div class="mb-4">
                <label for="participation_total" class="block text-gray-700 font-semibold">Jumlah Partisipan</label>
                <input type="number" name="participation_total" id="participation_total"
                    value="{{ $workProgram->participation_total }}"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="participation_coverage" class="block text-gray-700 font-semibold">
                    Cakupan Partisipasi
                </label>

                <select name="participation_coverage" id="participation_coverage"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="Prodi" {{ $workProgram->participation_coverage == 'Prodi' ? 'selected' : '' }}>
                        Prodi</option>
                    <option value="Sekolah" {{ $workProgram->participation_coverage == 'Sekolah' ? 'selected' : '' }}>
                        Sekolah</option>
                    <option value="IPB" {{ $workProgram->participation_coverage == 'IPB' ? 'selected' : '' }}>IPB
                    </option>
                    <option value="Nasional"
                        {{ $workProgram->participation_coverage == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                    <option value="Internasional"
                        {{ $workProgram->participation_coverage == 'Internasional' ? 'selected' : '' }}>Internasional
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label for="lpj_url" class="block font-semibold text-gray-700">Upload LPJ (pdf, max: 5 MB)</label>
                @if ($workProgram->lpj_url)
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">File LPJ:</p>
                        <p class="text-xs text-gray-800">{{ explode('/', $workProgram->lpj_url)[1] }}</p>
                        <p class="text-xs text-red-600">Mengunggah file baru akan menimpa file lama, kosongkan jika
                            tidak ingin mengubah file</p>
                    </div>
                @else
                    <div class="bg-red-200 p-4 mb-2 rounded-lg">
                        <p class="text-gray-800">File LPJ belum diunggah, silahkan unggah disini</p>
                    </div>
                @endif

                <input type="file" name="lpj_url" id="lpj_url" accept="application/pdf"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="spg_url" class="block font-semibold text-gray-700">Upload SPG (pdf, max: 5 MB)</label>
                @if ($workProgram->spg_url)
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">File SPG:</p>
                        <p class="text-xs text-gray-800">{{ explode('/', $workProgram->spg_url)[1] }}</p>
                        <p class="text-xs text-red-600">Mengunggah file baru akan menimpa file lama, kosongkan jika
                            tidak ingin mengubah file</p>
                    </div>
                @else
                    <div class="bg-red-200 p-4 mb-2 rounded-lg">
                        <p class="text-gray-800">File SPG belum diunggah, silahkan unggah disini</p>
                    </div>
                @endif

                <input type="file" name="spg_url" id="spg_url" accept="application/pdf"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex space-x-2">
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('dashboard.workProgram.detail', ['workProgram' => $workProgram, 'department' => $workProgram->department]) }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const displayInput = document.getElementById("funds_display");
        const hiddenInput = document.getElementById("funds");

        function formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'decimal'
            }).format(value);
        }

        function unformatCurrency(value) {
            return value.replace(/\./g, "");
        }

        displayInput.addEventListener("input", function(e) {
            let rawValue = this.value.replace(/\D/g, "");
            this.value = formatCurrency(rawValue);
            hiddenInput.value = unformatCurrency(rawValue);
        });
    });
</script>
