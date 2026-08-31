<x-app-layout class="bg-slate-50">

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
                                Anda memiliki akses penuh gamifikasi PKBM Terang Mulia. Kelola data pengguna dengan bijak.
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
                    <svg width="18" height="18" class="text-indigo-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5z"></path>
                    </svg>
                    <span>Pusat Data Administrasi</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- CARD 1: DATA GURU --}}
                    <a href="{{ route('gurus.index') }}" class="group relative bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-blue-900/10 hover:-translate-y-1.5 transition-all duration-300 overflow-hidden h-full flex flex-col">
                        {{-- Background Accent --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full opacity-50 group-hover:scale-110 transition-transform"></div>

                        <div class="p-8 flex items-center gap-6 relative z-10">
                            {{-- Icon Wrapper --}}
                            <div class="w-18 h-18 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shadow-inner group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                                <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>

                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-slate-800 group-hover:text-blue-700 transition-colors">Data Guru</h3>
                                <p class="text-slate-500 text-xs mt-1 mb-3">Kelola Data Guru.</p>

                                {{-- Mini Stat --}}
                                <div class="inline-flex items-center gap-2 bg-slate-50 px-3 py-1 rounded-lg border border-slate-100">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Total:</span>
                                    <span class="text-xs font-black text-blue-600">{{ \App\Models\User::where('role', 'guru')->count() }} Guru</span>
                                </div>
                            </div>

                            {{-- Arrow Icon --}}
                            <div class="text-slate-300 group-hover:text-blue-600 group-hover:translate-x-2 transition-all">
                                <svg width="24" height="24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </a>

                    {{-- CARD 2: DATA SISWA --}}
                    @php 
                        $hasForgotReport = \App\Models\User::where('role', 'siswa')->where('forgot_password_reported', true)->exists(); 
                    @endphp
                    <a href="{{ route('siswas.index') }}" class="group relative bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-green-900/10 hover:-translate-y-1.5 transition-all duration-300 overflow-hidden h-full flex flex-col">
                        {{-- Background Accent --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-50 to-transparent rounded-bl-full opacity-50 group-hover:scale-110 transition-transform"></div>

                        <div class="p-8 flex items-center gap-6 relative z-10">
                            {{-- Icon Wrapper --}}
                            <div class="w-18 h-18 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center shadow-inner group-hover:bg-green-600 group-hover:text-white transition-all duration-300 flex-shrink-0 relative">
                                <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7zM16 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                @if($hasForgotReport)
                                    <span class="absolute -top-1 -right-1 flex h-4 w-4">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 border-2 border-white"></span>
                                    </span>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-slate-800 group-hover:text-green-700 transition-colors">Data Siswa</h3>
                                <p class="text-slate-500 text-xs mt-1 mb-3">Kelola Data Siswa.</p>

                                {{-- Mini Stat --}}
                                <div class="inline-flex items-center gap-2 bg-slate-50 px-3 py-1 rounded-lg border border-slate-100">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Total:</span>
                                    <span class="text-xs font-black text-green-600">{{ \App\Models\User::where('role', 'siswa')->count() }} Siswa</span>
                                </div>
                            </div>

                            {{-- Arrow Icon --}}
                            <div class="text-slate-300 group-hover:text-green-600 group-hover:translate-x-2 transition-all">
                                <svg width="24" height="24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

            {{-- 3. FOOTER QUOTE --}}
            <div class="text-center pt-10 border-t border-slate-200">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">
                    Panel Administrator • gamifikasi PKBM Terang Mulia  
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
