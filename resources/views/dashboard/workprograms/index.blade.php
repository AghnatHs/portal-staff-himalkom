<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row items-center">
            <div class="text-sm text-gray-500 font-medium">
                <nav class="flex items-center space-x-2">
                    <span >
                        Program Kerja
                    </span>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-800 font-semibold">
                        {{ $department->name }}
                    </span>
                </nav>
            </div>
        </div>
    </x-slot>
    <div class="max-w-6xl mx-auto py-2 px-2">

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

        <div class="flex justify-end mb-3">
            <a href="{{ route('dashboard.workProgram.create', ['department' => $department]) }}"
                class="mr-2 lg:mr-0 
                       bg-[#111B5A] 
                       text-white 
                       px-2 py-1 md:px-3 md:py-2 
                       rounded-lg 
                       shadow-md 
                       hover:bg-[#14267B] 
                       transition duration-200 
                       text-[12px] md:text-sm
                       font-semibold 
                       tracking-wide 
                       flex items-center gap-2">
                <span class="text-lg md:text-xl">+</span>
                Tambah Program Kerja
            </a>
        </div>



        <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 lg:gap-4">
            @forelse ($department->workPrograms as $workProgram)
                <div
                    class="flex flex-col gap-1 lg:gap-3 relative mx-2 lg:mx-0 bg-white/90 border border-[#111B5A]/30 hover:border-[#14267B]/40 shadow-inner hover:shadow-md rounded-xl p-5 transition duration-200 transform backdrop-blur-sm">

                    <p class="absolute bottom-3 right-4 text-[10px] text-gray-400 italic">
                        ID: {{ $workProgram->id }}
                    </p>

                    <h2 class="uppercase text-lg md:text-xl font-bold text-[#111B5A] tracking-wide">
                        {{ $workProgram->name }}
                    </h2>

                    <div>
                        <h3 class="text-[14px] md:text-sm font-semibold text-[#14267B]">Description</h3>
                        <p class="text-gray-600 text-[12px] md:text-sm mt-1 break-words">
                            {{ Str::limit($workProgram->description, 60, '...') }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-[14px] md:text-sm font-semibold text-[#14267B]">Timeline</h3>
                        <p class="mt-1 text-[12px] md:text-sm text-gray-500">{{ $workProgram->timeline_range_text }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-[14px] md:text-sm text-[#14267B]">Last Updated</h3>
                        <p class="mt-1 text-[12px] md:text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($workProgram->created_at)->diffForHumans() }}
                        </p>
                    </div>

                    <div class="mt-2">
                        <a href="{{ route('dashboard.workProgram.detail', ['workProgram' => $workProgram, 'department' => $department]) }}"
                            class="inline-flex items-center gap-1 text-white bg-[#111B5A] hover:bg-[#14267B] transition px-3 py-1.5 text-xs font-medium rounded-full">
                            Read More
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
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
