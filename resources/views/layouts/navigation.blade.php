<nav x-data="{ open: false, showInfo: false, openShop: false }"
     class="bg-gradient-to-r from-blue-600 to-indigo-700 border-b border-white/10 sticky top-0 z-50 shadow-lg transition-all duration-300">

    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
        <div class="flex justify-between h-16 md:h-20">

            {{-- ========================================== --}}
            {{-- BAGIAN KIRI: LOGO & BRANDING --}}
            {{-- ========================================== --}}
            <div class="flex shrink-0">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">

                        {{-- Logo Sekolah --}}
                        <div class="bg-white p-1 md:p-1.5 rounded-full shadow-md group-hover:scale-105 transition-transform duration-300">
                            <img src="{{ asset('img/logo_sekolah.png') }}" alt="Logo" class="block h-8 w-8 md:h-10 md:w-10 object-contain">
                        </div>

                        {{-- Icon Maskot --}}
                        <div class="relative -ml-2 md:-ml-3 z-10 group-hover:-translate-y-1 transition-transform duration-300">
                            <img src="{{ asset('img/maskot_nav.png') }}" alt="Leo" class="h-10 w-auto md:h-12 drop-shadow-lg filter brightness-110">
                        </div>

                        {{-- Teks Brand (Hidden di Mobile) --}}
                        <div class="flex flex-col ml-1 hidden lg:flex">
                            <span class="font-extrabold text-lg text-white tracking-tight drop-shadow-sm group-hover:text-yellow-300 transition-colors leading-tight">
                                Gamifikasi
                            </span>
                            <span class="text-[9px] text-blue-100 font-medium tracking-widest uppercase opacity-80 group-hover:opacity-100 leading-tight">
                                SMP Terang Mulia
                            </span>
                        </div>
                    </a>
                </div>

                {{-- ========================================== --}}
                {{-- MENU NAVIGASI (DESKTOP) --}}
                {{-- ========================================== --}}
                <div class="hidden md:flex items-center space-x-1 lg:space-x-2 ml-2 lg:ml-6">

                    {{-- 1. Tombol Dashboard --}}
                    <a href="{{ route('dashboard') }}"
                       class="group inline-flex items-center px-2 lg:px-3 py-2 rounded-full text-xs lg:text-sm font-bold transition-all duration-300 ease-in-out gap-1.5
                       {{ request()->routeIs('dashboard') || request()->routeIs('siswa.dashboard')
                           ? 'bg-white text-blue-900 shadow-md'
                           : 'text-white hover:bg-white/10 hover:text-white' }}">

                        <svg class="h-4 w-4 lg:h-5 lg:w-5" viewBox="0 0 20 20" fill="currentColor">>
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    {{-- 2. Tombol Info Maskot --}}
                    <button @click="showInfo = true" class="group inline-flex items-center px-2 lg:px-3 py-2 rounded-full text-xs lg:text-sm font-bold text-blue-100 hover:bg-white/10 hover:text-yellow-300 transition-all duration-300 gap-1.5 border border-transparent hover:border-yellow-300/30 whitespace-nowrap">
                        <svg class="h-4 w-4 lg:h-5 lg:w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <span>Info LUKA & Rank</span>
                    </button>

                    {{-- 3. Tombol Tukar Aset (Shop) --}}
                    <button @click="openShop = true" class="group inline-flex items-center px-2 lg:px-3 py-2 rounded-full text-xs lg:text-sm font-bold text-white bg-yellow-500 hover:bg-yellow-400 transition-all duration-300 gap-1.5 shadow-md hover:shadow-lg shadow-yellow-500/20 transform hover:-translate-y-0.5 whitespace-nowrap">
                        <svg class="h-4 w-4 lg:h-5 lg:w-5 animate-pulse" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                        <span>Tukar Aset</span>
                        <span class="bg-black/10 px-1.5 py-0.5 rounded-md text-[10px] font-black min-w-[30px] text-center">
                            {{ Auth::user()->points }}
                        </span>
                    </button>

                    {{-- 4. TOMBOL RAID MAFIA (LOGIKA BARU: GURU KE MONITOR, SISWA KE MAIN) --}}
                    @php
                        $raidEvent = \App\Models\RaidEvent::first();
                        $isLive = $raidEvent && ($raidEvent->status == 'live' || $raidEvent->status == 'lobby');

                        // LOGIKA PEMBEDA RUTE
                        $eventRoute = '#';
                        if(Auth::user()->role == 'siswa') {
                            $eventRoute = route('siswa.raid.index');
                        } else {
                            // Guru/Admin masuk ke Monitor
                            $eventRoute = route('guru.raid.monitor');
                        }
                    @endphp

                    <a href="{{ $eventRoute }}"
                       class="group inline-flex items-center px-3 py-2 rounded-full text-xs lg:text-sm font-bold text-white bg-red-600 hover:bg-red-500 transition-all duration-300 gap-1.5 shadow-md hover:shadow-lg shadow-red-600/30 transform hover:-translate-y-0.5 whitespace-nowrap {{ $isLive ? 'animate-pulse ring-2 ring-red-400' : '' }}">
                        <svg class="h-4 w-4 lg:h-5 lg:w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                        </svg>
                        <span>EVENT SPESIAL</span>
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                            </span>
                    </a>


                </div>
            </div>

            {{-- ========================================== --}}
            {{-- BAGIAN KANAN: PROFILE USER --}}
            {{-- ========================================== --}}
            <div class="hidden md:flex items-center ml-auto pl-2">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center pl-3 pr-1 py-1 border border-white/20 text-xs lg:text-sm leading-4 font-medium rounded-full text-white bg-white/10 hover:bg-white/20 focus:outline-none transition ease-in-out duration-150 shadow-sm backdrop-blur-sm group">
                            <div class="flex flex-col items-end mr-2">
                                <span class="font-bold tracking-wide group-hover:text-yellow-300 transition-colors max-w-[80px] lg:max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                <span class="text-[9px] text-blue-200 uppercase tracking-wider">{{ Auth::user()->role ?? 'Siswa' }}</span>
                            </div>
                            <div class="h-8 w-8 rounded-full overflow-hidden border-2 border-white/50 group-hover:border-yellow-300 transition-colors shrink-0">
                                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=fbbf24&color=ffffff' }}"
                                     alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                            </div>
                            <div class="ml-1 text-blue-200">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100 bg-gray-50">
                            <p class="text-xs text-gray-500">Login sebagai:</p>
                            <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50 hover:text-red-700 font-medium">
                                {{ __('Keluar / Logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- TOMBOL HAMBURGER (MOBILE) --}}
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-blue-100 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MENU MOBILE (RESPONSIVE) --}}
    {{-- ========================================== --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white shadow-xl border-t border-gray-100 absolute w-full z-50 rounded-b-2xl">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-lg">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <button @click="showInfo = true; open = false" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-blue-800 hover:bg-blue-50 hover:border-blue-300 transition duration-150 ease-in-out rounded-lg">
                Tentang LUKA & Rank
            </button>

            <button @click="openShop = true; open = false" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-bold text-orange-600 hover:text-orange-800 hover:bg-orange-50 hover:border-orange-300 transition duration-150 ease-in-out rounded-lg">
                🛒 Tukar Aset ({{ Auth::user()->points }} XP)
            </button>

            {{-- Mobile Link Logic --}}
            @php
                $mobileRoute = (Auth::user()->role == 'siswa') ? route('siswa.raid.index') : route('guru.raid.monitor');
            @endphp
            <a href="{{ $mobileRoute }}" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-bold text-red-600 hover:text-red-800 hover:bg-red-50 hover:border-red-300 transition duration-150 ease-in-out rounded-lg">
                ⚔️ EVENT SPESIAL (Raid)
            </a>

            @if(Auth::user()->role == 'guru' || Auth::user()->role == 'admin')
                <x-responsive-nav-link :href="route('shop-guru.index')" class="rounded-lg text-blue-600 font-bold">
                    Kelola Shop
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-4 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
            <div class="px-4 flex items-center gap-3">
                 <div class="h-10 w-10 rounded-full overflow-hidden border border-gray-300">
                    <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=random' }}"
                         class="h-full w-full object-cover">
                </div>
                <div>
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-lg">
                    {{ __('Profil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50 rounded-lg">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL POPUP (INFO & SHOP) - FULL CODE --}}
    {{-- ========================================== --}}

    {{-- Modal Info LUKA --}}
    <div x-show="showInfo" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4">

        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="showInfo = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all border border-white/50">

                {{-- Tombol Close --}}
                <div class="absolute right-4 top-4 z-20">
                    <button @click="showInfo = false" class="bg-white/80 hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-full p-2 transition-all shadow-sm">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="bg-white pb-8">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6 text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-yellow-400/20 rounded-full blur-2xl"></div>
                        <h2 class="text-3xl font-black text-white flex items-center justify-center gap-3 relative z-10"><span>🐵</span> Teman Belajar Kita</h2>
                        <p class="text-blue-100 text-sm mt-1 font-medium relative z-10">Kenali partner suksesmu dan tingkatan karirmu!</p>
                    </div>
                    <div class="px-6 py-8 sm:px-10 space-y-10">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-1 shadow-md border border-blue-100">
                            <div class="bg-white/60 backdrop-blur-sm rounded-[20px] p-6 sm:p-8 flex flex-col md:flex-row items-center gap-8">
                                <div class="w-full md:w-auto flex justify-center mb-4 md:mb-0 relative">
                                    <div class="absolute inset-0 bg-yellow-400 rounded-full blur-2xl opacity-40 animate-pulse"></div>
                                    <img src="{{ asset('img/maskot.png') }}" alt="LUKA Maskot" class="w-56 h-56 object-contain relative z-10 drop-shadow-2xl hover:scale-110 transition-transform duration-500 transform -rotate-3 hover:rotate-0">
                                </div>
                                <div class="text-center md:text-left flex-1">
                                    <div class="inline-block bg-blue-100 text-blue-700 text-[10px] font-black px-3 py-1 rounded-full mb-3 uppercase tracking-wider">Mentor Sukses</div>
                                    <h3 class="text-2xl font-black text-gray-800 mb-3">Hai, Aku <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">LUKA</span>! 👋</h3>
                                    <div class="text-sm text-gray-600 leading-relaxed font-medium space-y-3">
                                        <p>Nama lengkapku <span class="text-blue-700 font-bold">Raden Kamandaka (Lutung Kasarung)</span>. "Kalian tahu Raden Kamandaka? Dia itu calon Raja (Sultan), asetnya triliunan. Tapi dia rela hidup susah, menyamar, <span class="text-red-500 font-bold">dan belajar dari bawah."</span></p>
                                        <p class="bg-white/50 p-3 rounded-lg border-l-4 border-yellow-400 italic text-gray-700">"Sekolah adalah fase 'penyamaran' kalian. Mungkin sekarang kalian merasa 'miskin' atau 'buang waktu' dibanding teman yang sudah kerja. Tapi ini adalah fase mengumpulkan <span class="text-orange-500 font-bold">Data & Strategi 📈</span>. Tanpa fase ini, kalian tidak akan pernah matang untuk memimpin kerajaan bisnis kalian nanti 💰."</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="text-center mb-6">
                                <h3 class="text-2xl font-black text-gray-800 flex items-center justify-center gap-2"><span>🏆</span> Jenjang Karir & Aset</h3>
                                <p class="text-gray-500 text-sm font-medium">Kumpulkan poin XP untuk menaikkan status sosialmu!</p>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                                <div class="group bg-gradient-to-br from-white to-orange-50 p-4 rounded-2xl border border-orange-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all text-center">
                                    <div class="h-16 w-16 mx-auto mb-3 relative">
                                        <div class="absolute inset-0 bg-orange-400 rounded-full blur opacity-20 group-hover:opacity-40 transition"></div>
                                        <img src="{{ asset('img/bronze.png') }}" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition">
                                    </div>
                                    <h4 class="font-black text-xs text-amber-700 uppercase mb-1">Bronze</h4>
                                    <span class="block mt-2 text-[10px] bg-white border border-orange-200 text-orange-600 rounded-full py-0.5 font-bold">0-12 Pts</span>
                                </div>
                                <div class="group bg-gradient-to-br from-white to-gray-50 p-4 rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all text-center">
                                    <div class="h-16 w-16 mx-auto mb-3 relative">
                                        <div class="absolute inset-0 bg-gray-400 rounded-full blur opacity-20 group-hover:opacity-40 transition"></div>
                                        <img src="{{ asset('img/silver.png') }}" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition">
                                    </div>
                                    <h4 class="font-black text-xs text-gray-600 uppercase mb-1">Silver</h4>
                                    <span class="block mt-2 text-[10px] bg-white border border-gray-200 text-gray-600 rounded-full py-0.5 font-bold">13-24 Pts</span>
                                </div>
                                <div class="group bg-gradient-to-br from-yellow-50 to-amber-50 p-4 rounded-2xl border border-yellow-200 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all text-center ring-2 ring-yellow-400/30 transform scale-105 z-10">
                                    <div class="h-16 w-16 mx-auto mb-3 relative">
                                        <div class="absolute inset-0 bg-yellow-400 rounded-full blur opacity-30 group-hover:opacity-50 transition"></div>
                                        <img src="{{ asset('img/gold.png') }}" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition">
                                    </div>
                                    <h4 class="font-black text-xs text-yellow-700 uppercase mb-1">Gold</h4>
                                    <span class="block mt-2 text-[10px] bg-yellow-400 text-yellow-900 rounded-full py-0.5 font-bold shadow-sm">25-36 Pts</span>
                                </div>
                                <div class="group bg-gradient-to-br from-white to-cyan-50 p-4 rounded-2xl border border-cyan-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all text-center">
                                    <div class="h-16 w-16 mx-auto mb-3 relative">
                                        <div class="absolute inset-0 bg-cyan-400 rounded-full blur opacity-20 group-hover:opacity-40 transition"></div>
                                        <img src="{{ asset('img/platinum.png') }}" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition">
                                    </div>
                                    <h4 class="font-black text-xs text-cyan-700 uppercase mb-1">Platinum</h4>
                                    <span class="block mt-2 text-[10px] bg-white border border-cyan-200 text-cyan-600 rounded-full py-0.5 font-bold">37-48 Pts</span>
                                </div>
                                <div class="group bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-2xl border border-blue-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all text-center">
                                    <div class="h-16 w-16 mx-auto mb-3 relative">
                                        <div class="absolute inset-0 bg-blue-500 rounded-full blur opacity-20 group-hover:opacity-40 transition"></div>
                                        <img src="{{ asset('img/diamond.png') }}" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition">
                                    </div>
                                    <h4 class="font-black text-xs text-blue-700 uppercase mb-1">Diamond</h4>
                                    <span class="block mt-2 text-[10px] bg-white border border-blue-200 text-blue-600 rounded-full py-0.5 font-bold">49-60 Pts</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 sm:px-10 text-center">
                        <button @click="showInfo = false" class="w-full sm:w-auto bg-blue-600 text-white font-bold py-3 px-10 rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">Siap, Mengerti! 🚀</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Shop --}}
    <div x-show="openShop" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4">

        <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="openShop = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-4xl bg-slate-900 rounded-3xl shadow-2xl overflow-hidden border border-white/10">
                <div class="absolute right-4 top-4 z-20">
                    <button @click="openShop = false" class="bg-white/20 text-white p-2 rounded-full"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>

                {{-- ISI MODAL SHOP --}}
                <div class="relative bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-8 sm:px-10 overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-white/5 text-9xl font-black select-none">XP</div>
                    <div class="relative z-10 flex justify-between items-end">
                        <div>
                            <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-1">Saldo Aset Anda</p>
                            <h2 class="text-5xl font-black text-white flex items-center gap-2"><span>{{ Auth::user()->points }}</span><span class="text-2xl text-yellow-400">XP</span></h2>
                            <p class="text-white/60 text-xs mt-2 w-3/4">"Gunakan modal belajarmu untuk membeli keuntungan saat ujian. Bijaklah dalam berinvestasi!"</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-8 sm:px-10 bg-slate-50">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded text-sm font-bold flex items-center gap-2">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded text-sm font-bold flex items-center gap-2">{{ session('error') }}</div>
                    @endif

                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2"><span>🛒</span> Katalog Penukaran</h3>
                        <span class="text-xs font-bold text-red-500 bg-red-100 px-3 py-1 rounded-full animate-pulse">Stok Terbatas!</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if(isset($shopItems) && count($shopItems) > 0)
                            @foreach($shopItems as $item)
                                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 relative overflow-hidden group hover:border-blue-400 transition-all">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-lg">{{ $item->name }}</h4>
                                            <p class="text-slate-500 text-xs mt-1 leading-relaxed line-clamp-2">{{ $item->description }}</p>
                                        </div>
                                        <div class="bg-blue-100 text-blue-600 font-black text-lg px-3 py-1 rounded-lg shrink-0 ml-2">{{ $item->price }} XP</div>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-xs font-bold {{ $item->stock > 0 ? 'text-slate-400' : 'text-red-500' }}">Stok: {{ $item->stock }} Unit</span>
                                        <form action="{{ route('siswa.shop.buy', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-white text-sm font-bold py-2 px-4 rounded-lg transition-colors shadow-lg disabled:opacity-50 disabled:cursor-not-allowed {{ Auth::user()->points >= $item->price && $item->stock > 0 ? 'bg-slate-800 hover:bg-blue-600' : 'bg-gray-400' }}" {{ (Auth::user()->points < $item->price || $item->stock <= 0) ? 'disabled' : '' }}>
                                                @if($item->stock <= 0) Habis ❌ @elseif(Auth::user()->points < $item->price) Saldo Kurang 🔒 @else Beli Aset 🛒 @endif
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-2 text-center py-8 text-gray-400">Belum ada barang di bursa. Tunggu Guru mengisinya ya! 🦁</div>
                        @endif
                    </div>
                    <div class="mt-8 text-center"><p class="text-xs text-slate-400 italic">*Penukaran aset hanya dapat dilakukan saat jam sekolah dengan persetujuan Admin/Guru.</p></div>
                </div>
            </div>
        </div>
    </div>

</nav>
