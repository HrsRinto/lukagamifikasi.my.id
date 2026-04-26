<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                ✏️ Edit Soal
            </h2>
            <a href="{{ route('soals.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('soals.update', $soal->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- KOLOM KIRI: EDITOR SOAL & JAWABAN (2/3 Lebar) --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Kartu Pertanyaan --}}
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <label class="block text-gray-700 text-sm font-bold mb-3 flex items-center gap-2">
                                <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">Q</span>
                                Pertanyaan Soal
                            </label>

                            {{-- UPDATE 1: Menambahkan old() agar data muncul --}}
                            <textarea name="pertanyaan" rows="4"
                                class="w-full border-gray-200 bg-gray-50 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition p-4 text-lg text-gray-800 placeholder-gray-400"
                                placeholder="Tuliskan pertanyaan anda disini..." required>{{ old('pertanyaan', $soal->question) }}</textarea>
                        </div>

                        {{-- Kartu Pilihan Jawaban --}}
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-gray-700 font-bold mb-4 flex items-center gap-2">
                                <span class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold">A</span>
                                Pilihan Jawaban & Kunci
                            </h3>
                            <p class="text-xs text-gray-400 mb-6">Ketik jawaban pada kolom teks, dan <strong>klik lingkaran</strong> pada jawaban yang benar.</p>

                            <div class="grid grid-cols-1 gap-4">
                                @php
                                    // Mapping data database ke tampilan
                                    $options = [
                                        'A' => $soal->option_a,
                                        'B' => $soal->option_b,
                                        'C' => $soal->option_c,
                                        'D' => $soal->option_d
                                    ];
                                @endphp

                                @foreach($options as $key => $value)
                                <div class="relative group">
                                    <div class="flex items-center">
                                        {{-- Huruf A/B/C/D --}}
                                        <div class="absolute left-0 pl-4 z-10 flex items-center pointer-events-none">
                                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center font-bold text-sm transition-colors duration-200
                                                {{ (old('kunci_jawaban', $soal->correct_answer) == $key) ? 'border-green-500 bg-green-500 text-white' : 'border-gray-300 text-gray-400 group-hover:border-indigo-400' }}">
                                                {{ $key }}
                                            </div>
                                        </div>

                                        {{-- UPDATE 2: Input Text dengan VALUE dari database (menggunakan old) --}}
                                        <input type="text" name="pilihan_{{ strtolower($key) }}"
                                            value="{{ old('pilihan_'.strtolower($key), $value) }}"
                                            class="w-full pl-16 pr-4 py-4 border-2 rounded-xl focus:ring-0 transition-all font-medium
                                            {{ (old('kunci_jawaban', $soal->correct_answer) == $key) ? 'border-green-500 bg-green-50 text-green-900' : 'border-gray-200 hover:border-indigo-200 focus:border-indigo-500' }}"
                                            placeholder="Jawaban {{ $key }}" required>

                                        {{-- UPDATE 3: Radio Button otomatis CHECKED sesuai database --}}
                                        <input type="radio" name="kunci_jawaban" value="{{ $key }}"
                                            {{ (old('kunci_jawaban', $soal->correct_answer) == $key) ? 'checked' : '' }}
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                            title="Klik untuk menandai ini sebagai kunci jawaban benar">

                                        {{-- Indikator "BENAR" --}}
                                        @if(old('kunci_jawaban', $soal->correct_answer) == $key)
                                        <div class="absolute right-4 text-green-600 font-bold text-xs bg-green-100 px-2 py-1 rounded-md">
                                            BENAR
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    {{-- KOLOM KANAN: PENGATURAN (1/3 Lebar) --}}
                    <div class="lg:col-span-1 space-y-6">

                        {{-- Panel Pengaturan --}}
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-6">
                            <h3 class="text-gray-800 font-bold text-lg mb-4">Pengaturan Soal</h3>

                            {{-- Level Kesulitan --}}
                            <div class="mb-6">
                                <label class="block text-gray-600 text-sm font-bold mb-2">Level Kesulitan</label>
                                <div class="relative">
                                    {{-- UPDATE 4: Dropdown otomatis SELECTED sesuai database --}}
                                    <select name="difficulty" class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl">
                                        <option value="easy" {{ (old('difficulty', $soal->difficulty ?? 'easy') == 'easy') ? 'selected' : '' }}>🟢 Easy (Mudah)</option>
                                        <option value="medium" {{ (old('difficulty', $soal->difficulty ?? 'easy') == 'medium') ? 'selected' : '' }}>🟡 Medium (Sedang)</option>
                                        <option value="hard" {{ (old('difficulty', $soal->difficulty ?? 'easy') == 'hard') ? 'selected' : '' }}>🔴 Hard (Sulit)</option>
                                    </select>
                                </div>
                                <p class="text-xs text-gray-400 mt-2">
                                    *Poin dihitung otomatis: Easy(1), Medium(2), Hard(3).
                                </p>
                            </div>

                            <hr class="border-gray-100 my-6">

                            {{-- Tombol Aksi --}}
                            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition hover:scale-[1.02]">
                                Simpan Perubahan
                            </button>

                            <div class="mt-4 text-center">
                                <form action="{{ route('soals.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-gray-400 hover:text-red-500 bg-transparent border-none cursor-pointer">
                                        Hapus Soal Ini
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
