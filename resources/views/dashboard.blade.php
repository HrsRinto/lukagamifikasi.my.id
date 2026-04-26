<x-app-layout>

    <div class="py-8 bg-slate-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- 1. HERO SECTION (Admin Style - Dark & Premium) --}}
            <div class="relative bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-900 rounded-3xl p-10 md:p-12 text-white shadow-2xl overflow-hidden group">

                {{-- Decorative Elements --}}
                <div class="absolute top-0 right-0 h-full w-1/3 bg-white/5 skew-x-12 transform origin-bottom transition-transform group-hover:skew-x-6 duration-700"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">

                        <div>
                            {{-- FITUR BARU: STATUS ONLINE ADMIN --}}
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-700/50 border border-slate-600 text-xs font-bold mb-4 backdrop-blur-md shadow-sm">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                </span>
                                <span class="text-emerald-300">Status Administrator: Aktif</span>
                            </div>

                            <h1 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight">
                                Selamat Datang, <span class="text-indigo-300">{{ Auth::user()->name }}</span>
                            </h1>
                            <p class="text-slate-300 text-base max-w-2xl leading-relaxed">
                                Anda memiliki akses penuh untuk mengelola ekosistem gamifikasi. Kelola data pengguna dengan bijak.
                            </p>
                        </div>

                        {{-- Jam / Tanggal (Opsional, pemanis dashboard) --}}
                        <div class="hidden md:block text-right">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Hari ini</p>
                            <p class="text-2xl font-black text-white">{{ now()->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. MENU UTAMA (Grid Cards) --}}
            <div>
                <h3 class="text-lg font-bold text-slate-700 mb-6 pl-1 border-l-4 border-slate-800 flex items-center gap-2">
                    ⚡ Pusat Data
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- CARD 1: DATA GURU --}}
                    <a href="{{ route('gurus.index') }}" class="group relative bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-blue-900/10 hover:-translate-y-2 transition-all duration-300 overflow-hidden h-full flex flex-col">
                        {{-- Background Accent --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full opacity-50 group-hover:scale-110 transition-transform"></div>

                        <div class="p-8 flex items-center gap-6 relative z-10">
                            {{-- Icon Wrapper --}}
                            <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-4xl shadow-inner group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                💼
                            </div>

                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-slate-800 group-hover:text-blue-700 transition-colors">Data Guru</h3>
                                <p class="text-slate-500 text-sm mt-1 mb-3">Kelola akun pengajar & akses.</p>

                                {{-- Mini Stat --}}
                                <div class="inline-flex items-center gap-2 bg-slate-50 px-3 py-1 rounded-lg border border-slate-100">
                                    <span class="text-xs font-bold text-slate-400 uppercase">Total:</span>
                                    <span class="text-sm font-black text-blue-600">{{ \App\Models\User::where('role', 'guru')->count() }} Guru</span>
                                </div>
                            </div>

                            {{-- Arrow Icon --}}
                            <div class="text-slate-300 group-hover:text-blue-600 group-hover:translate-x-2 transition-all">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </a>

                    {{-- CARD 2: DATA SISWA --}}
                    <a href="{{ route('siswas.index') }}" class="group relative bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-green-900/10 hover:-translate-y-2 transition-all duration-300 overflow-hidden h-full flex flex-col">
                        {{-- Background Accent --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-50 to-transparent rounded-bl-full opacity-50 group-hover:scale-110 transition-transform"></div>

                        <div class="p-8 flex items-center gap-6 relative z-10">
                            {{-- Icon Wrapper --}}
                            <div class="w-20 h-20 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-4xl shadow-inner group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                                👨‍🎓
                            </div>

                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-slate-800 group-hover:text-green-700 transition-colors">Data Siswa</h3>
                                <p class="text-slate-500 text-sm mt-1 mb-3">Kelola siswa, kelas & poin.</p>

                                {{-- Mini Stat --}}
                                <div class="inline-flex items-center gap-2 bg-slate-50 px-3 py-1 rounded-lg border border-slate-100">
                                    <span class="text-xs font-bold text-slate-400 uppercase">Total:</span>
                                    <span class="text-sm font-black text-green-600">{{ \App\Models\User::where('role', 'siswa')->count() }} Siswa</span>
                                </div>
                            </div>

                            {{-- Arrow Icon --}}
                            <div class="text-slate-300 group-hover:text-green-600 group-hover:translate-x-2 transition-all">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

            {{-- 3. FOOTER QUOTE --}}
            <div class="text-center pt-10 border-t border-slate-200">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">
                    Panel Administrator • Sistem Gamifikasi
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
