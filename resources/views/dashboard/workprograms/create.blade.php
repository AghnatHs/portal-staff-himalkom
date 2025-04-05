<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row items-center">
            <a href="{{ route('dashboard.workProgram.index', ['department' => $department]) }}"
                class="text-gray-900 hover:text-gray-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l-7 7 7 7" />
                </svg>
            </a>
            <h2 class="font-bold text-gray-900 leading-tight text-md md:text-lg lg:text-xl">
                Program Kerja - {{ $department->name }}
            </h2>
        </div>

    </x-slot>
    <div
        class="relative max-w-[90dvw] lg:max-w-6xl mx-auto mt-2 mb-8 p-2 bg-white rounded-xl md:rounded-2xl lg:rounded-3xl shadow-lg 
            before:absolute before:inset-0 before:-z-10 before:bg-gradient-to-r before:from-gray-200 before:to-gray-100 
            before:rounded-[inherit] before:p-[0.5px]">
        <div class="bg-white rounded-lg md:rounded-xl lg:rounded-2xl p-6 border border-gray-200">
            <h1 class="font-extrabold text-gray-900 md:mb-2 text-center text-lg md:text-xl lg:text-3xl">Tambah Program
                Kerja - {{ $department->name }}
            </h1>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-md mb-2 border border-red-400">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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

            <form action="{{ route('dashboard.workProgram.store', ['department' => $department]) }}" method="POST"
                enctype="multipart/form-data" class="md:p-3 rounded-md space-y-2 md:space-y-4">
                @csrf

                @php
                    $fields = [
                        'name' => 'Nama Program',
                        'description' => 'Deskripsi',
                        'start_at' => 'Mulai',
                        'finished_at' => 'Selesai',
                        'funds' => 'Dana',
                        'sources_of_funds' => 'Sumber Dana',
                        'participation_total' => 'Total Partisipasi',
                        'participation_coverage' => 'Cakupan Partisipasi',
                        'lpj_url' => 'Upload LPJ (pdf, max: 5 MB)',
                        'spg_url' => 'Upload SPG (pdf, max: 5 MB)',
                    ];
                @endphp


                @foreach ($fields as $field => $label)
                    <div>
                        <label for="{{ $field }}"
                            class=" mb-1 block font-normal text-gray-600 text-sm md:text-lg lg:text-lg">{{ $label }}</label>
                        @if ($field === 'description')
                            <textarea name="{{ $field }}" required
                                class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-3 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-gray-700 text-sm md:text-md lg:text-lg">{{ old($field) }}</textarea>
                        @elseif($field === 'funds')
                            <input type="text" id="funds_display" value="{{ number_format(0, 0, ',', '.') }}"
                                class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-gray-700 text-sm md:text-md lg:text-lg">
                            <input type="hidden" name="funds" id="funds" value="{{ old('funds', 0) }}">
                        @elseif($field === 'participation_coverage')
                            <select name="participation_coverage" id="participation_coverage"
                                class="select2 bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-gray-700  text-sm md:text-md lg:text-lg">
                                <option value="Prodi" class="text-gray-700  text-sm md:text-md lg:text-lg">Prodi
                                </option>
                                <option value="Sekolah" class="text-gray-700  text-sm md:text-md lg:text-lg">Sekolah
                                </option>
                                <option value="IPB" class="text-gray-700  text-sm md:text-md lg:text-lg">IPB</option>
                                <option value="Nasional" class="text-gray-700  text-sm md:text-md lg:text-lg">Nasional
                                </option>
                                <option value="Internasional" class="text-gray-700  text-sm md:text-md lg:text-lg">
                                    Internasional</option>
                            </select>
                        @elseif($field === 'sources_of_funds')
                            <div class="mb-4">
                                <div class="space-y-2">
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="sources_of_funds[]" value="BPPTN"
                                            {{ in_array('BPPTN', old('sources_of_funds', [])) ? 'checked' : '' }}
                                            class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md focus:ring-1 focus:ring-gray-100 focus:shadow-lg focus:border-gray-100 focus:outline-none text-gray-700  text-sm md:text-md lg:text-lg">
                                        <span class="text-gray-700 ">BPPTN</span>
                                    </label>

                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="sources_of_funds[]" value="Dana Sekolah"
                                            {{ in_array('Dana Sekolah', old('sources_of_funds', [])) ? 'checked' : '' }}
                                            class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md focus:ring-1 focus:ring-gray-100 focus:shadow-lg focus:border-gray-100 focus:outline-none text-gray-700  text-sm md:text-md lg:text-lg">
                                        <span class="text-gray-700 ">Dana Sekolah</span>
                                    </label>

                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="sources_of_funds[]" value="Mandiri"
                                            {{ in_array('Mandiri', old('sources_of_funds', [])) ? 'checked' : '' }}
                                            class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md focus:ring-1 focus:ring-gray-100 focus:shadow-lg focus:border-gray-100 focus:outline-none text-gray-700  text-sm md:text-md lg:text-lg">
                                        <span class="text-gray-700 ">Mandiri</span>
                                    </label>
                                </div>
                            </div>
                        @elseif($field === 'lpj_url')
                            <div class="mb-4">
                                <input type="file" name="lpj_url" id="lpj_url" accept="application/pdf"
                                    class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-gray-700  text-sm md:text-md lg:text-lg">
                            </div>
                        @elseif($field === 'spg_url')
                            <div class="mb-4">
                                <input type="file" name="spg_url" id="spg_url" accept="application/pdf"
                                    class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-gray-700  text-sm md:text-md lg:text-lg">
                            </div>
                        @else
                            <input
                                type="{{ in_array($field, ['start_at', 'finished_at']) ? 'date' : (in_array($field, ['funds', 'participation_total']) ? 'number' : 'text') }}"
                                name="{{ $field }}" value="{{ old($field) }}" required
                                class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-sm text-gray-700  md:text-md lg:text-lg">
                        @endif
                        @error($field)
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <div class="text-center">
                    <button type="submit"
                        class="mt-4  bg-[#14267B] text-white px-4 py-2 md:px-6 md:py-2 rounded-xl shadow hover:bg-[#111B5A] hover:transition text-sm md:text-md lg:text-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
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

    $(document).ready(function() {
        $('#participation_coverage').select2();
    });
    
    FilePond.create(document.getElementById('lpj_url'), {
        allowMultiple: false,
        acceptedFileTypes: ['application/pdf'],
        labelIdle: 'Drag & Drop file LPJ atau <span class="filepond--label-action text-[#14267B">Klik di sini</span>',
        storeAsFile: true
    });

    FilePond.create(document.getElementById('spg_url'), {
        allowMultiple: false,
        acceptedFileTypes: ['application/pdf'],
        labelIdle: 'Drag & Drop file SPG atau <span class="filepond--label-action text-[#14267B">Klik di sini</span>',
        storeAsFile: true
    });
</script>
