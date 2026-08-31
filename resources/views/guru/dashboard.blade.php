<x-app-layout class="bg-slate-50">

    <div class="py-8 bg-slate-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- 1. WELCOME HERO SECTION --}}
            <div class="relative bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-8 md:p-12 text-white shadow-2xl shadow-indigo-950/20 overflow-hidden group border border-white/5">

                {{-- Glowing Mesh Effects --}}
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-60 h-60 bg-emerald-500/5 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        {{-- Badge Guru Aktif --}}
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-bold mb-5 backdrop-blur-md shadow-sm">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                            <span class="text-indigo-200">Mode Guru Aktif</span>
                        </div>
                        <h1 class="text-3xl md:text-5xl font-black mb-3 tracking-tight leading-tight">
                            Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-amber-300 to-yellow-400 font-extrabold">{{ Auth::user()->name }}</span>! 👋
                        </h1>
                        <p class="text-slate-300 text-sm md:text-base max-w-2xl font-medium leading-relaxed opacity-90">
                            Siap menginspirasi siswa hari ini? Pantau perkembangan kelas, kelola materi gamifikasi, atur bursa privilese, dan event raid dengan mudah.
                        </p>
                    </div>

                    {{-- Quick Action Button --}}
                    <a href="{{ route('materis.index') }}" class="flex-shrink-0 group bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-500 hover:to-indigo-600 text-white px-6 py-4 rounded-2xl font-bold shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-3 border border-indigo-500/30">
                        <div class="bg-white/10 p-2 rounded-xl group-hover:bg-white/20 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <span>Buat Materi Baru</span>
                    </a>
                </div>
            </div>

            {{-- 2. STATS OVERVIEW (Cards Minimalis Modern) --}}
            <div>
                <h3 class="text-base font-bold text-slate-800 mb-5 pl-1.5 border-l-4 border-indigo-600 flex items-center gap-2 tracking-wider uppercase">
                    📊 Statistik Kelas
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Stat 1: Total Siswa --}}
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 group flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm border border-blue-100/50 shrink-0">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Siswa</p>
                                <h4 class="text-3xl font-black text-slate-800 mt-1">
                                    {{ $stats['total_siswa'] }}
                                </h4>
                            </div>
                        </div>
                        <span class="text-xs text-blue-500 font-bold bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all">Siswa</span>
                    </div>

                    {{-- Stat 2: Modul Materi --}}
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-purple-200 transition-all duration-300 group flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 shadow-sm border border-purple-100/50 shrink-0">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Modul Aktif</p>
                                <h4 class="text-3xl font-black text-slate-800 mt-1">
                                    {{ $stats['total_materi'] }}
                                </h4>
                            </div>
                        </div>
                        <span class="text-xs text-purple-500 font-bold bg-purple-50 px-2.5 py-1 rounded-full border border-purple-100 group-hover:bg-purple-600 group-hover:text-white group-hover:border-purple-600 transition-all">Modul</span>
                    </div>

                    {{-- Stat 3: Bank Soal --}}
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-orange-200 transition-all duration-300 group flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-all duration-300 shadow-sm border border-orange-100/50 shrink-0">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Bank Soal</p>
                                <h4 class="text-3xl font-black text-slate-800 mt-1">
                                    {{ $stats['total_soal'] }}
                                </h4>
                            </div>
                        </div>
                        <span class="text-xs text-orange-500 font-bold bg-orange-50 px-2.5 py-1 rounded-full border border-orange-100 group-hover:bg-orange-600 group-hover:text-white group-hover:border-orange-600 transition-all">Soal</span>
                    </div>
                </div>
            </div>

            {{-- 3. MENU UTAMA (Grid Cards Elegan) --}}
            <div>
                <h3 class="text-base font-bold text-slate-800 mb-6 pl-1.5 border-l-4 border-indigo-600 flex items-center gap-2 tracking-wider uppercase">
                    🚀 Menu Utama
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    {{-- Card 1: Manajemen Modul --}}
                    <a href="{{ route('materis.index') }}" class="group relative bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden h-full flex flex-col">
                        <div class="absolute top-0 right-0 w-36 h-36 bg-gradient-to-br from-indigo-50/50 to-blue-50/50 rounded-bl-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>

                        <div class="p-8 relative z-10 flex-1 flex flex-col">
                            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-xl flex items-center justify-center mb-6 shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">Manajemen Modul</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1">
                                Upload video materi pembelajaran, atur judul modul, dan kelola kuis interaktif untuk siswa.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center text-indigo-600 text-sm font-bold group-hover:gap-2 transition-all">
                                Buka Manajemen
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>

                    {{-- Card 2: Kelola Shop --}}
                    <a href="{{ route('shop-guru.index') }}" class="group relative bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden h-full flex flex-col">
                        <div class="absolute top-0 right-0 w-36 h-36 bg-gradient-to-br from-green-50/50 to-emerald-50/50 rounded-bl-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>

                        <div class="p-8 relative z-10 flex-1 flex flex-col">
                            <div class="w-12 h-12 bg-green-50 text-green-650 border border-green-100 rounded-xl flex items-center justify-center mb-6 shadow-sm group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-green-600 transition-colors">Bursa Privilese</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1">
                                Atur reward (privilese) untuk 4 peringkat teratas dan lihat siapa saja siswa yang mengklaim reward.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center text-green-600 text-sm font-bold group-hover:gap-2 transition-all">
                                Kelola Toko
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>

                    {{-- Card 3: Leaderboard --}}
                    <a href="{{ route('leaderboard') }}" class="group relative bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden h-full flex flex-col">
                        <div class="absolute top-0 right-0 w-36 h-36 bg-gradient-to-br from-yellow-50/50 to-orange-50/50 rounded-bl-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>

                        <div class="p-8 relative z-10 flex-1 flex flex-col">
                            <div class="w-12 h-12 bg-yellow-50 text-yellow-600 border border-yellow-100 rounded-xl flex items-center justify-center mb-6 shadow-sm group-hover:bg-yellow-500 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-yellow-600 transition-colors">Leaderboard</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1">
                                Lihat peringkat siswa, pantau rank tertinggi, dan evaluasi persaingan kompetitif di kelas.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center text-yellow-600 text-sm font-bold group-hover:gap-2 transition-all">
                                Lihat Peringkat
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>

                    {{-- Card 4: RAID MAFIA EVENT --}}
                    <a href="{{ route('guru.raid.index') }}" class="group relative bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden h-full flex flex-col">
                        <div class="absolute top-0 right-0 w-36 h-36 bg-gradient-to-br from-red-50/50 to-rose-50/50 rounded-bl-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>

                        <div class="p-8 relative z-10 flex-1 flex flex-col">
                            <div class="w-12 h-12 bg-red-50 text-red-650 border border-red-100 rounded-xl flex items-center justify-center mb-6 shadow-sm group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-red-600 transition-colors">Raid Mafia Event</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1">
                                Kontrol pusat untuk Event Spesial. Buka room, input soal, dan mulai pertempuran BOSS!
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center text-red-600 text-sm font-bold group-hover:gap-2 transition-all">
                                Buka Control Center
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

            {{-- 4. FOOTER QUOTE --}}
            <div class="text-center pt-10 border-t border-slate-200">
                <p class="text-slate-400 text-xs italic font-semibold">
                    "Pendidikan bukan persiapan untuk hidup; pendidikan adalah hidup itu sendiri." - John Dewey
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
