<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER: JUDUL & KEMBALI --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-800 tracking-tight">Editor Soal</h1>
                    <p class="text-gray-500 text-sm mt-1">Perbarui konten materi dan kunci jawaban dengan mudah.</p>
                </div>
                <a href="{{ route('materis.show', $soal->materi_id) }}" class="group inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-bold text-gray-600 hover:text-indigo-600 hover:border-indigo-300 transition shadow-sm">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>

            <form action="{{ route('soals.update', $soal->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                    {{-- KOLOM KIRI (2/3): KONTEN SOAL --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- CARD UTAMA --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                            {{-- Header Card --}}
                            <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                                <span class="bg-indigo-100 text-indigo-600 p-1.5 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </span>
                                <h3 class="font-bold text-gray-800">Konten Pertanyaan</h3>
                            </div>

                            <div class="p-6 space-y-8">
                                {{-- INPUT PERTANYAAN --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider text-xs">Pertanyaan Utama</label>
                                    <textarea name="pertanyaan" rows="8" class="w-full border-gray-200 bg-gray-50 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base p-4 transition" placeholder="Tuliskan soal di sini..." required>{{ old('pertanyaan', $soal->pertanyaan ?? $soal->question) }}</textarea>
                                </div>

                                {{-- INPUT OPSI JAWABAN --}}
                                <div>
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider text-xs">Opsi Jawaban</label>
                                        <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded">Klik lingkaran di kanan untuk set Kunci Benar</span>
                                    </div>

                                    <div class="space-y-4">
                                        @foreach(['A', 'B', 'C', 'D'] as $key)
                                            @php
                                                // Logika pengambilan data lama
                                                $dbOpsi = 'option_' . strtolower($key);
                                                if(!isset($soal->$dbOpsi)) $dbOpsi = 'opsi_' . strtolower($key);
                                                if(!isset($soal->$dbOpsi)) $dbOpsi = 'pilihan_' . strtolower($key);

                                                $val = $soal->$dbOpsi ?? '';
                                                $dbKey = $soal->kunci_jawaban ?? $soal->correct_answer;
                                                $isCorrect = (strtoupper(old('kunci_jawaban', $dbKey)) == $key);
                                            @endphp

                                            <div class="group relative flex items-center">
                                                {{-- Label Huruf --}}
                                                <div class="absolute left-0 pl-3 z-10 flex items-center justify-center h-full">
                                                    <span class="w-8 h-8 flex items-center justify-center rounded-lg font-bold text-sm transition-colors
                                                        {{ $isCorrect ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500 group-hover:bg-indigo-100 group-hover:text-indigo-600' }}">
                                                        {{ $key }}
                                                    </span>
                                                </div>

                                                {{-- Input Text --}}
                                                <input type="text" name="pilihan_{{ strtolower($key) }}"
                                                       value="{{ old('pilihan_'.strtolower($key), $val) }}"
                                                       class="w-full pl-14 pr-32 py-3.5 border-2 rounded-xl text-gray-700 font-medium transition-all
                                                       {{ $isCorrect ? 'border-emerald-500 bg-emerald-50/10 ring-1 ring-emerald-500' : 'border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white' }}"
                                                       placeholder="Jawaban opsi {{ $key }}..." required>

                                                {{-- Radio Button Custom (Kunci) --}}
                                                <div class="absolute right-0 pr-3 h-full flex items-center">
                                                    <label class="cursor-pointer flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition select-none">
                                                        <input type="radio" name="kunci_jawaban" value="{{ $key }}" {{ $isCorrect ? 'checked' : '' }} class="peer sr-only">

                                                        <span class="text-xs font-bold text-gray-400 peer-checked:text-emerald-600 transition-colors">
                                                            {{ $isCorrect ? 'Kunci Benar' : 'Set Benar' }}
                                                        </span>

                                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center transition-all">
                                                            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN (1/3): CONFIG --}}
                    <div class="lg:col-span-1 space-y-6">

                        {{-- CARD CONFIG --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Konfigurasi
                            </h3>

                            {{-- Pilihan Difficulty (Visual) --}}
                            <div class="space-y-3 mb-6">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tingkat Kesulitan</label>

                                @php $diff = old('difficulty', $soal->difficulty ?? 'easy'); @endphp

                                <label class="cursor-pointer block relative">
                                    <input type="radio" name="difficulty" value="easy" class="peer sr-only" {{ $diff == 'easy' ? 'checked' : '' }}>
                                    <div class="p-3 rounded-xl border-2 border-gray-100 hover:border-green-200 bg-white peer-checked:border-green-500 peer-checked:bg-green-50 transition-all flex justify-between items-center">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                                            <span class="font-bold text-gray-600 peer-checked:text-green-700 text-sm">Easy</span>
                                        </div>
                                        <span class="text-xs font-bold bg-gray-100 text-gray-500 px-2 py-1 rounded">1 Poin</span>
                                    </div>
                                </label>

                                <label class="cursor-pointer block relative">
                                    <input type="radio" name="difficulty" value="medium" class="peer sr-only" {{ $diff == 'medium' ? 'checked' : '' }}>
                                    <div class="p-3 rounded-xl border-2 border-gray-100 hover:border-yellow-200 bg-white peer-checked:border-yellow-500 peer-checked:bg-yellow-50 transition-all flex justify-between items-center">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                                            <span class="font-bold text-gray-600 peer-checked:text-yellow-700 text-sm">Medium</span>
                                        </div>
                                        <span class="text-xs font-bold bg-gray-100 text-gray-500 px-2 py-1 rounded">2 Poin</span>
                                    </div>
                                </label>

                                <label class="cursor-pointer block relative">
                                    <input type="radio" name="difficulty" value="hard" class="peer sr-only" {{ $diff == 'hard' ? 'checked' : '' }}>
                                    <div class="p-3 rounded-xl border-2 border-gray-100 hover:border-red-200 bg-white peer-checked:border-red-500 peer-checked:bg-red-50 transition-all flex justify-between items-center">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                                            <span class="font-bold text-gray-600 peer-checked:text-red-700 text-sm">Hard</span>
                                        </div>
                                        <span class="text-xs font-bold bg-gray-100 text-gray-500 px-2 py-1 rounded">3 Poin</span>
                                    </div>
                                </label>
                            </div>

                            <hr class="border-gray-100 mb-6">

                            {{-- Save Button --}}
                            <button type="submit" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Perubahan
                            </button>

                            {{-- Delete Button (Link) --}}
                            <div class="mt-4 text-center">
                                <button type="button" onclick="if(confirm('Yakin hapus?')) document.getElementById('delete-form').submit()" class="text-xs text-red-400 hover:text-red-600 font-semibold hover:underline transition">
                                    Hapus Soal Ini
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

            {{-- Form Delete Hidden --}}
            <form id="delete-form" action="{{ route('soals.destroy', $soal->id) }}" method="POST" class="hidden">
                @csrf @method('DELETE')
            </form>

        </div>
    </div>
</x-app-layout>
