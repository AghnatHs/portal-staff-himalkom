<x-app-layout>
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">✏️ Edit Program Kerja</h2>

        @if (session('error'))
            <p class="text-red-500">{{ session('error') }}</p>
        @endif

        <form action="{{ route('dashboard.workProgram.update', ['workProgram' => $workProgram, 'slug' => $workProgram->department->slug]) }}" method="POST">
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
                <input type="number" name="funds" id="funds" value="{{ $workProgram->funds }}"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="source_of_funds" class="block text-gray-700 font-semibold">Sumber Dana</label>
                <input type="text" name="sources_of_funds" id="source_of_funds" value="{{ $workProgram->sources_of_funds }}"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="participation_total" class="block text-gray-700 font-semibold">Jumlah Partisipan</label>
                <input type="number" name="participation_total" id="participation_total" value="{{ $workProgram->participation_total }}"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="participation_coverage" class="block text-gray-700 font-semibold">Cakupan Partisipasi</label>
                <input type="text" name="participation_coverage" id="participation_coverage" value="{{ $workProgram->participation_coverage }}"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('dashboard.workProgram.detail', ['workProgram' => $workProgram, 'slug' => $workProgram->department->slug]) }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
