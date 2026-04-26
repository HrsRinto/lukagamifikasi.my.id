<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Materi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg relative">
                
                {{-- TOMBOL KEMBALI (YANG TADI ERROR) --}}
                <div class="absolute top-6 right-6">
                    <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm">
                        Batal & Kembali
                    </a>
                </div>

                <form action="{{ route('materis.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul Materi</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Contoh: Algoritma Dasar" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Penjelasan singkat materi..." required></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Link Video Youtube</label>
                        <input type="text" name="video_url" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="https://www.youtube.com/watch?v=..." required>
                        <p class="text-xs text-gray-500 mt-1">Pastikan link video valid dari Youtube.</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-bold shadow">
                            Simpan & Lanjut Buat Soal &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>