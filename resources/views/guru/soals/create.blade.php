<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Input Soal: {{ $materi_terpilih->title ?? 'Baru' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg relative border-t-4 
                {{ $kategori_otomatis == 'easy' ? 'border-green-500' : ($kategori_otomatis == 'medium' ? 'border-yellow-500' : 'border-red-500') }}">

                {{-- PROGRESS BAR & JUDUL NOMOR SOAL --}}
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <div>
                        <span class="text-gray-500 text-sm font-bold uppercase tracking-wider">SOAL NOMOR</span>
                        <h1 class="text-4xl font-black text-gray-800">{{ $nomor_soal }} <span class="text-lg text-gray-400">/ 15</span></h1>
                    </div>
                    
                    {{-- Badge Level Otomatis --}}
                    <div class="text-right">
                        @if($kategori_otomatis == 'easy')
                            <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-bold shadow-sm">LEVEL EASY (1 Poin)</span>
                        @elseif($kategori_otomatis == 'medium')
                            <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full font-bold shadow-sm">LEVEL MEDIUM (2 Poin)</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full font-bold shadow-sm">LEVEL HARD (3 Poin)</span>
                        @endif
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 px-4 py-3 rounded relative mb-6 animate-pulse">
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('soals.store') }}" method="POST">
                    @csrf
                    
                    {{-- DATA TERSEMBUNYI (HIDDEN) AGAR USER TIDAK PERLU INPUT --}}
                    {{-- 1. ID Materi --}}
                    <input type="hidden" name="materi_id" value="{{ $materi_terpilih->id ?? '' }}">
                    {{-- 2. Kategori Otomatis --}}
                    <input type="hidden" name="kategori" value="{{ $kategori_otomatis }}">
                    {{-- 3. Poin Otomatis --}}
                    <input type="hidden" name="points" value="{{ $poin_otomatis }}">

                    {{-- PERTANYAAN --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pertanyaan</label>
                        <textarea name="pertanyaan" rows="8" class="w-full border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Tulis soal nomor {{ $nomor_soal }} di sini..." required autofocus></textarea>
                    </div>

                     {{-- PILIHAN GANDA --}}
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center font-bold text-gray-400">A</span>
                            <input type="text" name="pilihan_a" class="pl-8 w-full border-gray-300 rounded-lg focus:ring-blue-500" placeholder="Pilihan A" required>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center font-bold text-gray-400">B</span>
                            <input type="text" name="pilihan_b" class="pl-8 w-full border-gray-300 rounded-lg focus:ring-blue-500" placeholder="Pilihan B" required>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center font-bold text-gray-400">C</span>
                            <input type="text" name="pilihan_c" class="pl-8 w-full border-gray-300 rounded-lg focus:ring-blue-500" placeholder="Pilihan C" required>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center font-bold text-gray-400">D</span>
                            <input type="text" name="pilihan_d" class="pl-8 w-full border-gray-300 rounded-lg focus:ring-blue-500" placeholder="Pilihan D" required>
                        </div>
                    </div>

                    {{-- KUNCI JAWABAN (Hanya ini yang dipilih manual) --}}
                    <div class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kunci Jawaban Benar</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-4 py-2 rounded-lg border hover:bg-blue-50">
                                <input type="radio" name="kunci_jawaban" value="A" required> <span class="font-bold">A</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-4 py-2 rounded-lg border hover:bg-blue-50">
                                <input type="radio" name="kunci_jawaban" value="B" required> <span class="font-bold">B</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-4 py-2 rounded-lg border hover:bg-blue-50">
                                <input type="radio" name="kunci_jawaban" value="C" required> <span class="font-bold">C</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-4 py-2 rounded-lg border hover:bg-blue-50">
                                <input type="radio" name="kunci_jawaban" value="D" required> <span class="font-bold">D</span>
                            </label>
                        </div>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="flex justify-between items-center pt-4 border-t">
                        <div class="text-sm text-gray-400 italic">
                            *Level dan Poin diatur otomatis oleh sistem.
                        </div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transform transition hover:scale-105">
                            @if($nomor_soal < 15)
                                Simpan & Lanjut Soal {{ $nomor_soal + 1 }} &rarr;
                            @else
                                Simpan & SELESAI (Final) 🏁
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>