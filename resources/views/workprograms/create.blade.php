<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-6 bg-gray-50 shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Buat Program Kerja untuk {{ $department->name }}</h1>

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

        <form action="{{ route('workProgram.store', ['slug' => $department->slug]) }}" method="POST" class=" p-6 shadow-md rounded-md space-y-4">
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
                    'participation_coverage' => 'Cakupan Partisipasi'
                ];
            @endphp

            @foreach ($fields as $field => $label)
                <div>
                    <label for="{{ $field }}" class="block font-semibold text-gray-700">{{ $label }}</label>
                    @if ($field === 'description')
                        <textarea name="{{ $field }}" required class="border p-3 w-full rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">{{ old($field) }}</textarea>
                    @else
                        <input type="{{ in_array($field, ['start_at', 'finished_at']) ? 'date' : (in_array($field, ['funds', 'participation_total']) ? 'number' : 'text') }}" 
                               name="{{ $field }}" value="{{ old($field) }}" required 
                               class="border p-3 w-full rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @endif
                    @error($field)
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach

            <div class="text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
