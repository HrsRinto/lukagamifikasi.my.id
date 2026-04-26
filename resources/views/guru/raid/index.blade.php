<x-app-layout>
    <div class="py-8 bg-slate-50 min-h-screen font-sans" x-data="{ showImportModal: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER TITLE & RESET --}}
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                        <span class="text-4xl">☠️</span> Control Center: Raid Mafia
                    </h2>
                    <p class="text-slate-500 text-sm font-medium ml-12">Panel kendali Guru untuk event gamifikasi.</p>
                </div>

                <form action="{{ route('guru.raid.reset') }}" method="POST" onsubmit="return confirm('⚠️ PERINGATAN: Reset akan menghapus semua progress. Lanjutkan?');">
                    @csrf
                    <button type="submit" class="bg-white border border-red-200 text-red-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-50 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Reset Event
                    </button>
                </form>
            </div>

            {{-- SECTION 1: STATUS CONTROL (TETAP SEPERTI SEBELUMNYA) --}}
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">🎮 Status Permainan</h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Status Closed --}}
                    <form action="{{ route('guru.raid.update_status') }}" method="POST" class="flex-1">
                        @csrf <input type="hidden" name="status" value="closed">
                        <button class="w-full py-4 rounded-xl font-bold border-2 transition-all flex flex-col items-center justify-center gap-1 {{ $event->status == 'closed' ? 'bg-slate-800 text-white border-slate-800 shadow-md transform scale-[1.02]' : 'bg-slate-50 text-slate-400 border-transparent hover:bg-slate-100' }}">
                            <span class="text-lg">⛔</span>
                            <span class="text-xs">TUTUP</span>
                        </button>
                    </form>

                    {{-- Status Lobby --}}
                    <form action="{{ route('guru.raid.update_status') }}" method="POST" class="flex-1">
                        @csrf <input type="hidden" name="status" value="lobby">
                        <button class="w-full py-4 rounded-xl font-bold border-2 transition-all flex flex-col items-center justify-center gap-1 {{ $event->status == 'lobby' ? 'bg-yellow-400 text-yellow-900 border-yellow-400 shadow-md transform scale-[1.02]' : 'bg-yellow-50 text-yellow-600/70 border-transparent hover:bg-yellow-100' }}">
                            <span class="text-lg">🕒</span>
                            <span class="text-xs">BUKA LOBBY</span>
                        </button>
                    </form>

                    {{-- Status Live --}}
                    <form action="{{ route('guru.raid.update_status') }}" method="POST" class="flex-1">
                        @csrf <input type="hidden" name="status" value="live">
                        <button class="w-full py-4 rounded-xl font-bold border-2 transition-all flex flex-col items-center justify-center gap-1 {{ $event->status == 'live' ? 'bg-red-600 text-white border-red-600 shadow-md transform scale-[1.02] animate-pulse' : 'bg-red-50 text-red-400 border-transparent hover:bg-red-100' }}">
                            <span class="text-lg">⚔️</span>
                            <span class="text-xs">MULAI PERANG</span>
                        </button>
                    </form>

                    {{-- Status Finished --}}
                    <div class="flex flex-col items-center justify-center border-2 {{ $event->status == 'finished' ? 'border-green-500 bg-green-50 text-green-700' : 'border-slate-100 bg-slate-50 text-slate-300' }} rounded-xl font-bold py-4">
                        <span class="text-lg">🏁</span>
                        <span class="text-xs">SELESAI</span>
                    </div>
                </div>

                {{-- CONFIG BAR (YANG DIRAPIKAN) --}}
                <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-6 items-center">

                    {{-- 1. Edit HP Boss --}}
                    <form action="{{ route('guru.raid.update_hp') }}" method="POST" class="relative group">
                        @csrf
                        <label class="text-[10px] font-bold text-slate-400 uppercase absolute -top-2 left-3 bg-white px-1">Hit Point Boss</label>
                        <div class="flex items-center">
                            <div class="bg-red-50 text-red-500 p-2.5 rounded-l-xl border-y border-l border-red-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <input type="number" name="hp_boss" value="{{ $event->total_hp }}" min="10" max="1000"
                                   class="w-full border-y border-red-100 text-center font-bold text-slate-700 focus:ring-0 focus:border-red-300 py-2" onchange="this.form.submit()">
                            <div class="bg-white border-y border-r border-red-100 p-2 rounded-r-xl text-xs font-bold text-slate-400">
                                / {{ $event->total_hp }}
                            </div>
                        </div>
                    </form>

                    {{-- 2. Edit Timer --}}
                    <form action="{{ route('guru.raid.update_timer') }}" method="POST" class="relative group">
                        @csrf
                        <label class="text-[10px] font-bold text-slate-400 uppercase absolute -top-2 left-3 bg-white px-1">Timer / Soal</label>
                        <div class="flex items-center">
                            <div class="bg-blue-50 text-blue-500 p-2.5 rounded-l-xl border-y border-l border-blue-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <input type="number" name="timer_seconds" value="{{ $event->timer_seconds ?? 30 }}" min="10" max="300"
                                   class="w-full border-y border-blue-100 text-center font-bold text-slate-700 focus:ring-0 focus:border-blue-300 py-2" onchange="this.form.submit()">
                            <div class="bg-white border-y border-r border-blue-100 p-2.5 rounded-r-xl text-xs font-bold text-slate-400">
                                Detik
                            </div>
                        </div>
                    </form>

                    {{-- 3. Monitor Info --}}
                    <div class="flex justify-between md:justify-end gap-3 items-center">
                        <div class="text-right mr-2">
                            <div class="text-xs text-slate-400 font-bold uppercase">Pasukan</div>
                            <div class="text-xl font-black text-slate-700">{{ $event->participants->count() }} <span class="text-xs font-medium text-slate-400">Siswa</span></div>
                        </div>
                        @if($event->status != 'closed')
                            <a href="{{ route('guru.raid.monitor') }}" target="_blank" class="bg-slate-800 text-white px-4 py-3 rounded-xl font-bold text-sm hover:bg-slate-700 transition flex items-center gap-2 shadow-lg shadow-slate-200">
                                📺 Monitor
                            </a>
                        @else
                            <button disabled class="bg-gray-100 text-gray-400 px-4 py-3 rounded-xl font-bold text-sm cursor-not-allowed flex items-center gap-2">
                                🚫 Offline
                            </button>
                        @endif
                    </div>

                </div>
            </div>

            {{-- SECTION 2: CONTENT & LIST --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- LEFT: INPUT ZONE --}}
                <div class="lg:col-span-4 space-y-6 sticky top-6">

                    {{-- Card: Import --}}
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 p-6 rounded-3xl border border-emerald-100 shadow-sm">
                        <h4 class="font-bold text-emerald-800 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                            Bank Soal Cepat
                        </h4>
                        <p class="text-xs text-emerald-600 mb-4">Ambil soal dari modul materi yang sudah ada.</p>
                        <button @click="showImportModal = true" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-200 transition transform hover:-translate-y-0.5">
                            Buka Bank Soal
                        </button>
                    </div>

                    {{-- Card: Manual Input --}}
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <span>✍️</span> Input Manual
                            </h3>
                        </div>

                        <form action="{{ route('guru.raid.store_soal') }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <textarea name="pertanyaan" rows="3" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm" required placeholder="Tulis pertanyaan di sini..."></textarea>
                            </div>

                            <div class="grid grid-cols-1 gap-2">
                                @foreach(['a','b','c','d'] as $opt)
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 uppercase">{{ $opt }}</div>
                                        <input type="text" name="opsi_{{ $opt }}" placeholder="Opsi {{ strtoupper($opt) }}" class="flex-1 bg-slate-50 border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 h-9" required>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase mb-2 block">Kunci Jawaban</label>
                                <div class="flex bg-slate-100 p-1 rounded-xl">
                                    @foreach(['a','b','c','d'] as $key)
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="kunci_jawaban" value="{{ $key }}" class="peer hidden" required>
                                            <div class="text-center py-2 rounded-lg text-sm font-bold text-slate-400 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow-md transition uppercase">
                                                {{ $key }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-200 transition transform hover:-translate-y-0.5 mt-2">
                                + Simpan Soal
                            </button>
                        </form>
                    </div>
                </div>

                {{-- RIGHT: QUESTION LIST (MODERNIZED) --}}
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">

                        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg">Daftar Amunisi (Soal)</h3>
                                <p class="text-xs text-slate-500">Total: <strong class="text-blue-600">{{ $event->soals->count() }}</strong> Pertanyaan Siap</p>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar bg-slate-50/30 max-h-[800px]">
                            @forelse($event->soals as $index => $soal)
                                <div class="group bg-white p-5 rounded-2xl border border-slate-200 hover:border-blue-400 hover:shadow-md transition relative">

                                    {{-- Header Soal --}}
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex gap-3">
                                            <div class="flex-shrink-0 w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold text-sm">
                                                {{ $index + 1 }}
                                            </div>
                                            <p class="font-bold text-slate-800 text-base mt-1 pr-8">{{ $soal->pertanyaan }}</p>
                                        </div>
                                        {{-- Delete Button --}}
                                        <form action="{{ route('guru.raid.destroy_soal', $soal->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');">
                                            @csrf @method('DELETE')
                                            <button class="text-slate-300 hover:text-red-500 hover:bg-red-50 p-2 rounded-lg transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Grid Jawaban (Modern) --}}
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm ml-11">
                                        <div class="flex items-center gap-3 p-2 rounded-lg border {{ $soal->kunci_jawaban == 'a' ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-100' }}">
                                            <span class="w-6 h-6 rounded flex items-center justify-center text-xs font-bold uppercase {{ $soal->kunci_jawaban == 'a' ? 'bg-green-500 text-white' : 'bg-slate-200 text-slate-500' }}">A</span>
                                            <span class="{{ $soal->kunci_jawaban == 'a' ? 'text-green-700 font-semibold' : 'text-slate-600' }}">{{ $soal->opsi_a }}</span>
                                            @if($soal->kunci_jawaban == 'a') <svg class="w-4 h-4 text-green-500 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> @endif
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg border {{ $soal->kunci_jawaban == 'b' ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-100' }}">
                                            <span class="w-6 h-6 rounded flex items-center justify-center text-xs font-bold uppercase {{ $soal->kunci_jawaban == 'b' ? 'bg-green-500 text-white' : 'bg-slate-200 text-slate-500' }}">B</span>
                                            <span class="{{ $soal->kunci_jawaban == 'b' ? 'text-green-700 font-semibold' : 'text-slate-600' }}">{{ $soal->opsi_b }}</span>
                                            @if($soal->kunci_jawaban == 'b') <svg class="w-4 h-4 text-green-500 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> @endif
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg border {{ $soal->kunci_jawaban == 'c' ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-100' }}">
                                            <span class="w-6 h-6 rounded flex items-center justify-center text-xs font-bold uppercase {{ $soal->kunci_jawaban == 'c' ? 'bg-green-500 text-white' : 'bg-slate-200 text-slate-500' }}">C</span>
                                            <span class="{{ $soal->kunci_jawaban == 'c' ? 'text-green-700 font-semibold' : 'text-slate-600' }}">{{ $soal->opsi_c }}</span>
                                            @if($soal->kunci_jawaban == 'c') <svg class="w-4 h-4 text-green-500 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> @endif
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg border {{ $soal->kunci_jawaban == 'd' ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-100' }}">
                                            <span class="w-6 h-6 rounded flex items-center justify-center text-xs font-bold uppercase {{ $soal->kunci_jawaban == 'd' ? 'bg-green-500 text-white' : 'bg-slate-200 text-slate-500' }}">D</span>
                                            <span class="{{ $soal->kunci_jawaban == 'd' ? 'text-green-700 font-semibold' : 'text-slate-600' }}">{{ $soal->opsi_d }}</span>
                                            @if($soal->kunci_jawaban == 'd') <svg class="w-4 h-4 text-green-500 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center h-64 text-slate-400">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <p class="font-medium">Belum ada soal.</p>
                                    <p class="text-xs">Mulai dengan menambahkan soal di sebelah kiri.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- MODAL IMPORT (TETAP) --}}
        {{-- ========================================== --}}
        {{-- MODAL IMPORT DARI BANK KUIS --}}
        {{-- ========================================== --}}
        <div x-show="showImportModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm" @click="showImportModal = false"></div>
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative w-full max-w-4xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">

                    {{-- Header Modal --}}
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-xl font-black text-slate-800 flex items-center gap-2"><span>📂</span> Import dari Bank Kuis</h3>
                        <button @click="showImportModal = false" class="bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-full p-2 transition"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    </div>

                    {{-- Body Modal --}}
                    <div class="px-6 py-6 max-h-[70vh] overflow-y-auto custom-scrollbar bg-slate-50">
                        @if($bankSoalKuis->isEmpty())
                            <div class="text-center py-10 text-slate-400"><p>Tidak ada soal yang ditemukan.</p></div>
                        @else
                            <div class="space-y-3">
                                @foreach($bankSoalKuis as $soalKuis)
                                    {{-- Cek apakah soal sudah ada --}}
                                    @php
                                        // Cek apakah pertanyaan ini ada di array $existingQuestions
                                        // Pastikan variabel $existingQuestions dikirim dari controller!
                                        $isTaken = in_array($soalKuis->question, $existingQuestions ?? []);
                                    @endphp

                                    <div class="flex items-center justify-between bg-white border border-slate-200 p-4 rounded-xl {{ $isTaken ? 'opacity-60 bg-slate-50' : 'hover:border-green-400 hover:shadow-md' }} transition group">
                                        <div class="flex-1 pr-4">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700 uppercase">
                                                    {{ $soalKuis->materi->judul ?? 'UMUM' }}
                                                </span>
                                                @if($isTaken)
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 uppercase border border-green-200 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        SUDAH DIAMBIL
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-sm font-bold text-slate-800 line-clamp-2">{{ $soalKuis->question }}</p>
                                            <div class="text-xs text-slate-500 mt-1">Kunci: <span class="font-bold text-green-600 uppercase">{{ $soalKuis->correct_answer }}</span></div>
                                        </div>

                                        @if($isTaken)
                                            {{-- Tampilan Jika Sudah Diambil (Tombol Disabled) --}}
                                            <button disabled class="bg-slate-100 border-2 border-slate-200 text-slate-400 px-4 py-2 rounded-lg font-bold text-sm cursor-not-allowed flex items-center gap-2">
                                                <span>Terambil</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                        @else
                                            {{-- Tampilan Jika Belum Diambil (Tombol Aktif) --}}
                                            <form action="{{ route('guru.raid.import_soal', $soalKuis->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-white border-2 border-slate-200 text-slate-600 hover:bg-green-50 hover:text-green-600 hover:border-green-500 px-4 py-2 rounded-lg font-bold text-sm transition flex items-center gap-2 shadow-sm">
                                                    <span>Ambil</span>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
