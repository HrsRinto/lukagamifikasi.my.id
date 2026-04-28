<x-app-layout>

    <div class="py-8 bg-slate-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- 1. WELCOME HERO SECTION (Modern Gradient) --}}
            <div class="relative bg-gradient-to-r from-blue-700 via-indigo-700 to-violet-800 rounded-3xl p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 overflow-hidden group">

                {{-- Decorative Blobs --}}
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-400/20 rounded-full blur-2xl"></div>

                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        {{-- Badge Guru Aktif --}}
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-xs font-bold mb-5 backdrop-blur-md shadow-sm">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                            </span>
                            Mode Guru Aktif
                        </div>
                        <h1 class="text-3xl md:text-4xl font-extrabold mb-3 tracking-tight leading-tight">
                            Selamat Datang, <span class="text-yellow-300">{{ Auth::user()->name }}</span>! 👋
                        </h1>
                        <p class="text-blue-100 text-base md:text-lg max-w-2xl font-medium leading-relaxed opacity-90">
                            Siap menginspirasi siswa hari ini? Pantau perkembangan kelas, kelola materi gamifikasi, dan atur bursa privilese dengan mudah.
                        </p>
                    </div>

                    {{-- Quick Action Button --}}
                    <a href="{{ route('materis.index') }}" class="flex-shrink-0 group bg-white text-indigo-700 px-6 py-4 rounded-2xl font-bold shadow-xl hover:shadow-2xl hover:bg-indigo-50 hover:-translate-y-1 transition-all duration-300 flex items-center gap-3">
                        <div class="bg-indigo-100 p-2 rounded-lg group-hover:bg-indigo-200 transition-colors">
                            <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <span>Buat Materi Baru</span>
                    </a>
                </div>
            </div>

            {{-- 2. STATS OVERVIEW (Cards Minimalis Modern) --}}
            <div>
                <h3 class="text-lg font-bold text-slate-700 mb-5 pl-1 border-l-4 border-indigo-500 flex items-center gap-2">
                    📊 Statistik Kelas
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Stat 1: Total Siswa --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-blue-200 transition-all duration-300 group">
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-inner">
                                👨‍🎓
                            </div>
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Siswa</p>
                                <h4 class="text-3xl font-black text-slate-800 mt-1">
                                    {{ $stats['total_siswa'] }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    {{-- Stat 2: Modul Materi --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-purple-200 transition-all duration-300 group">
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-3xl group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 shadow-inner">
                                📚
                            </div>
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Modul Aktif</p>
                                <h4 class="text-3xl font-black text-slate-800 mt-1">
                                    {{ $stats['total_materi'] }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    {{-- Stat 3: Bank Soal --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-orange-200 transition-all duration-300 group">
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-3xl group-hover:bg-orange-600 group-hover:text-white transition-all duration-300 shadow-inner">
                                📝
                            </div>
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Bank Soal</p>
                                <h4 class="text-3xl font-black text-slate-800 mt-1">
                                    {{ $stats['total_soal'] }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. MENU UTAMA (Grid Cards Elegan) --}}
            <div>
                <h3 class="text-lg font-bold text-slate-700 mb-6 pl-1 border-l-4 border-indigo-500 flex items-center gap-2">
                    🚀 Menu Utama
                </h3>

                {{-- UPDATE: Grid diubah jadi 4 kolom agar muat menu baru --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    {{-- Card 1: Manajemen Modul --}}
                    <a href="{{ route('materis.index') }}" class="group relative bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden h-full flex flex-col">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-indigo-50 to-blue-50 rounded-bl-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>

                        <div class="p-8 relative z-10 flex-1 flex flex-col">
                            <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                🖥️
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">Manajemen Modul</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1">
                                Upload video materi pembelajaran, atur judul modul, dan kelola kuis interaktif untuk siswa.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center text-indigo-600 text-sm font-bold group-hover:gap-2 transition-all">
                                Buka Manajemen
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>

                    {{-- Card 2: Kelola Shop --}}
                    <a href="{{ route('shop-guru.index') }}" class="group relative bg-white rounded-3xl shadow-md border-2 border-green-100 hover:border-green-400 hover:shadow-green-100/50 hover:-translate-y-2 transition-all duration-300 overflow-hidden h-full flex flex-col">

                        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-green-50 to-emerald-50 rounded-bl-full -mr-10 -mt-10 transition-transform group-hover:scale-110 opacity-50"></div>

                        <div class="p-8 relative z-10 flex-1 flex flex-col">
                            <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                🏪
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-green-600 transition-colors">Bursa Privilese</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1">
                                Atur "barang dagangan" (reward), stok, dan harga XP. Pantau siapa saja siswa yang membeli aset.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center text-green-600 text-sm font-bold group-hover:gap-2 transition-all">
                                Kelola Toko
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>

                    {{-- Card 3: Leaderboard --}}
                    <a href="{{ route('leaderboard') }}" class="group relative bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden h-full flex flex-col">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-yellow-50 to-orange-50 rounded-bl-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>

                        <div class="p-8 relative z-10 flex-1 flex flex-col">
                            <div class="w-14 h-14 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:bg-yellow-500 group-hover:text-white transition-colors duration-300">
                                🏆
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-yellow-600 transition-colors">Leaderboard</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1">
                                Lihat klasemen poin siswa, pantau rank tertinggi, dan evaluasi persaingan kompetitif di kelas.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center text-yellow-600 text-sm font-bold group-hover:gap-2 transition-all">
                                Lihat Peringkat
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>

                    {{-- Card 4: RAID MAFIA EVENT (BARU) --}}
                    <a href="{{ route('guru.raid.index') }}" class="group relative bg-white rounded-3xl shadow-md border-2 border-red-100 hover:border-red-500 hover:shadow-red-200/50 hover:-translate-y-2 transition-all duration-300 overflow-hidden h-full flex flex-col">

                        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-red-50 to-rose-50 rounded-bl-full -mr-10 -mt-10 transition-transform group-hover:scale-110 opacity-50"></div>

                        <div class="p-8 relative z-10 flex-1 flex flex-col">
                            <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                                ⚔️
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-red-600 transition-colors">Raid Mafia Event</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1">
                                Kontrol pusat untuk Event Spesial. Buka room, input soal kisi-kisi, dan mulai pertempuran boss!
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center text-red-600 text-sm font-bold group-hover:gap-2 transition-all">
                                Buka Control Center
                                <svg class="w-4 h-4 ml-1 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

            {{-- 4. FOOTER QUOTE --}}
            <div class="text-center pt-10 border-t border-slate-200">
                <p class="text-slate-400 text-sm italic font-medium">
                    "Pendidikan bukan persiapan untuk hidup; pendidikan adalah hidup itu sendiri." - John Dewey
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
