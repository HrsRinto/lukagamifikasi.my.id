<div x-data="{ open: false, showInfo: false, openShop: false }"
     class="sticky top-0 z-50 w-full px-2 sm:px-4 lg:px-8 py-3 md:py-4 pointer-events-none">
    <nav class="pointer-events-auto max-w-7xl mx-auto border transition-all duration-300 backdrop-blur-md relative
         {{ Auth::user()->role === 'guru' || Auth::user()->role === 'admin' 
            ? 'bg-gradient-to-r from-slate-950/95 via-indigo-950/90 to-slate-950/95 border-indigo-500/25 rounded-[1.75rem] md:rounded-full shadow-[0_20px_50px_rgba(79,70,229,0.15)] shadow-2xl' 
            : 'bg-gradient-to-r from-blue-600/90 to-indigo-700/90 border-white/15 rounded-[1.75rem] md:rounded-full shadow-2xl' }}">

        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
            <div class="flex justify-between h-16 md:h-20 items-center">

            {{-- ========================================== --}}
            {{-- BAGIAN KIRI: LOGO & BRANDING --}}
            {{-- ========================================== --}}
            <div class="flex shrink-0 items-center">
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
                                PKBM Terang Mulia
                            </span>
                        </div>
                    </a>
                </div>

                {{-- ========================================== --}}
                {{-- MENU NAVIGASI (DESKTOP - CENTERED) --}}
                {{-- ========================================== --}}
                <div class="hidden md:flex items-center justify-center flex-1 mx-4">
                    <div class="bg-white/10 border border-white/5 shadow-inner rounded-full px-5 py-2.5 flex items-center gap-5 lg:gap-7 backdrop-blur-md">

                        @if(Auth::user()->role === 'admin')
                            {{-- MENU NAVIGASI ADMIN --}}
                            
                            {{-- 1. Tombol Dashboard --}}
                            @php
                                $isAdminDashboard = request()->routeIs('dashboard');
                            @endphp
                            <div class="relative py-1 flex flex-col items-center">
                                <a href="{{ route('dashboard') }}"
                                   class="group inline-flex items-center text-xs lg:text-sm font-bold gap-1.5 transition-colors duration-300 focus:outline-none
                                   {{ $isAdminDashboard ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                                <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-indigo-400 rounded-full transition-transform duration-300 {{ $isAdminDashboard ? 'scale-x-100' : 'scale-x-0' }}"></span>
                            </div>

                            {{-- 2. Data Guru --}}
                            @php
                                $isGuruManage = request()->routeIs('gurus.*');
                            @endphp
                            <div class="relative py-1 flex flex-col items-center">
                                <a href="{{ route('gurus.index') }}"
                                   class="group inline-flex items-center text-xs lg:text-sm font-bold gap-1.5 transition-colors duration-300 focus:outline-none
                                   {{ $isGuruManage ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Data Guru</span>
                                </a>
                                <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-indigo-400 rounded-full transition-transform duration-300 {{ $isGuruManage ? 'scale-x-100' : 'scale-x-0' }}"></span>
                            </div>

                            {{-- 3. Data Siswa --}}
                            @php
                                $isSiswaManage = request()->routeIs('siswas.*');
                            @endphp
                            <div class="relative py-1 flex flex-col items-center">
                                <a href="{{ route('siswas.index') }}"
                                   class="group inline-flex items-center text-xs lg:text-sm font-bold gap-1.5 transition-colors duration-300 focus:outline-none
                                   {{ $isSiswaManage ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7zM16 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <span>Data Siswa</span>
                                </a>
                                <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-indigo-400 rounded-full transition-transform duration-300 {{ $isSiswaManage ? 'scale-x-100' : 'scale-x-0' }}"></span>
                            </div>

                        @elseif(Auth::user()->role === 'guru')
                            {{-- MENU NAVIGASI GURU --}}
                            
                            {{-- 1. Tombol Dashboard --}}
                            @php
                                $isDashboard = request()->routeIs('dashboard') || request()->routeIs('guru.dashboard');
                            @endphp
                            <div class="relative py-1 flex flex-col items-center">
                                <a href="{{ route('dashboard') }}"
                                   class="group inline-flex items-center text-xs lg:text-sm font-bold gap-1.5 transition-colors duration-300 focus:outline-none
                                   {{ $isDashboard ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                                <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-indigo-400 rounded-full transition-transform duration-300 {{ $isDashboard ? 'scale-x-100' : 'scale-x-0' }}"></span>
                            </div>

                            {{-- 2. Kelola Modul --}}
                            @php
                                $isMateri = request()->routeIs('materis.*') || request()->routeIs('soals.*');
                            @endphp
                            <div class="relative py-1 flex flex-col items-center">
                                <a href="{{ route('materis.index') }}"
                                   class="group inline-flex items-center text-xs lg:text-sm font-bold gap-1.5 transition-colors duration-300 focus:outline-none
                                   {{ $isMateri ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span>Kelola Modul</span>
                                </a>
                                <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-indigo-400 rounded-full transition-transform duration-300 {{ $isMateri ? 'scale-x-100' : 'scale-x-0' }}"></span>
                            </div>

                            {{-- 3. Bursa Privilese --}}
                            @php
                                $isShopGuru = request()->routeIs('shop-guru.*');
                            @endphp
                            <div class="relative py-1 flex flex-col items-center">
                                <a href="{{ route('shop-guru.index') }}"
                                   class="group inline-flex items-center text-xs lg:text-sm font-bold gap-1.5 transition-colors duration-300 focus:outline-none
                                   {{ $isShopGuru ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <span>Bursa Privilese</span>
                                </a>
                                <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-indigo-400 rounded-full transition-transform duration-300 {{ $isShopGuru ? 'scale-x-100' : 'scale-x-0' }}"></span>
                            </div>

                            {{-- 4. Control Center Raid --}}
                            @php
                                $raidEvent = \App\Models\RaidEvent::first();
                                $isLive = $raidEvent && ($raidEvent->status == 'live' || $raidEvent->status == 'lobby');
                                $isRaid = request()->routeIs('guru.raid.*');
                            @endphp
                            <div class="relative py-1 flex flex-col items-center">
                                <a href="{{ route('guru.raid.index') }}"
                                   class="group inline-flex items-center text-xs lg:text-sm font-bold gap-1.5 transition-colors duration-300 focus:outline-none
                                   {{ $isRaid ? 'text-white' : 'text-slate-300 hover:text-white' }}">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Control Center Raid</span>
                                    @if($isLive)
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                        </span>
                                    @endif
                                </a>
                                <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-indigo-400 rounded-full transition-transform duration-300 {{ $isRaid ? 'scale-x-100' : 'scale-x-0' }}"></span>
                            </div>

                        @else
                            {{-- MENU NAVIGASI SISWA --}}
                            
                            {{-- 1. Tombol Dashboard --}}
                            @php
                                $isDashboard = request()->routeIs('dashboard') || request()->routeIs('siswa.dashboard');
                            @endphp
                            <div class="relative py-1 flex flex-col items-center">
                                <a href="{{ route('dashboard') }}"
                                   class="group inline-flex items-center text-xs lg:text-sm font-bold gap-1.5 transition-colors duration-300 focus:outline-none
                                   {{ $isDashboard ? 'text-white' : 'text-blue-100 hover:text-white' }}">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                                <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-white rounded-full transition-transform duration-300 {{ $isDashboard ? 'scale-x-100' : 'scale-x-0' }}"></span>
                            </div>

                            {{-- 2. Tombol Info LUKA & Rank --}}
                            <div class="relative py-1 flex flex-col items-center">
                                <button @click="showInfo = true" 
                                        class="group inline-flex items-center text-xs lg:text-sm font-bold gap-1.5 transition-colors duration-300 focus:outline-none"
                                        :class="showInfo ? 'text-white' : 'text-blue-100 hover:text-white'">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Info LUKA & Rank</span>
                                </button>
                                <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-white rounded-full transition-transform duration-300"
                                      :class="showInfo ? 'scale-x-100' : 'scale-x-0'"></span>
                            </div>

                            {{-- 3. Tombol Tukar Aset (Shop) --}}
                            <div class="relative py-1 flex flex-col items-center">
                                <button @click="openShop = true" 
                                        class="group inline-flex items-center text-xs lg:text-sm font-bold gap-1.5 transition-colors duration-300 focus:outline-none"
                                        :class="openShop ? 'text-white' : 'text-blue-100 hover:text-white'">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                    </svg>
                                    <span>Bursa Privilese</span>
                                </button>
                                <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-white rounded-full transition-transform duration-300"
                                      :class="openShop ? 'scale-x-100' : 'scale-x-0'"></span>
                            </div>

                            {{-- 4. TOMBOL EVENT SPESIAL --}}
                            @php
                                $raidEvent = \App\Models\RaidEvent::first();
                                $isLive = $raidEvent && ($raidEvent->status == 'live' || $raidEvent->status == 'lobby');
                                $isEventActive = request()->routeIs('siswa.raid.index');
                            @endphp
                            <div class="relative py-1 flex flex-col items-center">
                                <a href="{{ route('siswa.raid.index') }}"
                                   class="group inline-flex items-center text-xs lg:text-sm font-bold gap-1.5 transition-colors duration-300 focus:outline-none
                                   {{ $isEventActive ? 'text-white' : 'text-blue-100 hover:text-white' }}">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Raid Mafia</span>
                                    @if($isLive)
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                        </span>
                                    @endif
                                </a>
                                <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-white rounded-full transition-transform duration-300 {{ $isEventActive ? 'scale-x-100' : 'scale-x-0' }}"></span>
                            </div>
                        @endif

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
                                <img src="{{ Auth::user()->photo_url }}"
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
    {{-- MENU MOBILE (RESPONSIVE FLOATING CARD) --}}
    {{-- ========================================== --}}
    <div :class="{'block': open, 'hidden': ! open}" 
         class="hidden md:hidden bg-white/95 backdrop-blur-md shadow-2xl border border-gray-100 absolute left-0 right-0 top-[calc(100%+0.75rem)] z-50 rounded-2xl mx-1 overflow-hidden transition-all duration-300">
        <div class="pt-3 pb-3 space-y-1 px-3">
            @if(Auth::user()->role === 'admin')
                {{-- MENU ADMIN MOBILE --}}
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-lg font-bold">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('gurus.index')" :active="request()->routeIs('gurus.*')" class="rounded-lg font-bold">
                    {{ __('Data Guru') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('siswas.index')" :active="request()->routeIs('siswas.*')" class="rounded-lg font-bold">
                    {{ __('Data Siswa') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->role === 'guru')
                {{-- MENU GURU MOBILE --}}
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('guru.dashboard')" class="rounded-lg font-bold">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('materis.index')" :active="request()->routeIs('materis.*') || request()->routeIs('soals.*')" class="rounded-lg font-bold">
                    {{ __('Kelola Modul') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('shop-guru.index')" :active="request()->routeIs('shop-guru.*')" class="rounded-lg font-bold">
                    {{ __('Bursa Privilese') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('guru.raid.index')" :active="request()->routeIs('guru.raid.*')" class="rounded-lg font-bold">
                    {{ __('Control Center Raid') }}
                </x-responsive-nav-link>
            @else
                {{-- MENU SISWA MOBILE --}}
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('siswa.dashboard')" class="rounded-lg font-bold">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <button @click="showInfo = true; open = false" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-bold text-slate-700 hover:text-blue-800 transition duration-150 ease-in-out rounded-lg">
                    ℹ️ Info LUKA & Rank
                </button>

                <button @click="openShop = true; open = false" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-bold text-slate-700 hover:text-blue-800 transition duration-150 ease-in-out rounded-lg">
                    🛒 Bursa Privilese
                </button>

                <a href="{{ route('siswa.raid.index') }}" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-bold text-slate-700 hover:text-blue-800 transition duration-150 ease-in-out rounded-lg">
                    ⚔️ Event Spesial
                </a>
            @endif
        </div>

        <div class="pt-4 pb-4 border-t border-gray-100 bg-slate-50/80">
            <div class="px-4 flex items-center gap-3">
                 <div class="h-10 w-10 rounded-full overflow-hidden border border-slate-200 shadow-sm shrink-0">
                    <img src="{{ Auth::user()->photo_url }}"
                         class="h-full w-full object-cover">
                </div>
                <div class="min-w-0 flex-1">
                    <div class="font-bold text-base text-slate-800 truncate">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1 px-3">
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

    </nav>

    {{-- ========================================== --}}
    {{-- MODAL POPUP (INFO & SHOP) - FULL CODE --}}
    {{-- ========================================== --}}
    <div class="pointer-events-auto">

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
                    <div class="bg-blue-600 px-8 py-6 text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-yellow-400/20 rounded-full blur-2xl"></div>
                        <h2 class="text-3xl font-black text-white flex items-center justify-center gap-3 relative z-10"><span></span> Teman Belajar Kita</h2>
                        <p class="text-blue-100 text-sm mt-1 font-medium relative z-10">Kenali partner suksesmu dan tingkatan karirmu!</p>
                    </div>
                    <div class="px-6 py-8 sm:px-10 space-y-10">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl p-1 shadow-md border border-blue-100">
                            <div class="bg-white/60 backdrop-blur-sm rounded-[20px] p-6 sm:p-8 flex flex-col md:flex-row items-center gap-8">
                                <div class="w-full md:w-auto flex justify-center mb-4 md:mb-0 relative">
                                    <div class="absolute inset-0 bg-yellow-400 rounded-full blur-2xl opacity-40 animate-pulse"></div>
                                    <img src="{{ asset('img/maskot.png') }}" alt="LUKA Maskot" class="w-56 h-56 object-contain relative z-10 drop-shadow-2xl hover:scale-110 transition-transform duration-500 transform -rotate-3 hover:rotate-0">
                                </div>
                                <div class="text-center md:text-left flex-1">
                                    <div class="inline-block bg-blue-100 text-blue-700 text-[10px] font-black px-3 py-1 rounded-full mb-3 uppercase tracking-wider">Mentor Sukses</div>
                                    <h3 class="text-2xl font-black text-gray-800 mb-3">Hai, Aku <span class="text-blue-600">LUKA</span>! </h3>
                                    <div class="text-sm text-gray-600 leading-relaxed font-medium space-y-3">
                                        <p>Nama lengkapku <span class="text-blue-700 font-bold">Raden Kamandaka (Lutung Kasarung)</span>. "Kalian tahu Raden Kamandaka? Dia itu calon Raja (Sultan), asetnya triliunan. Tapi dia rela hidup susah, menyamar, <span class="text-red-500 font-bold">dan belajar dari bawah."</span></p>
                                        <p class="bg-white/50 p-3 rounded-lg border-l-4 border-yellow-400 italic text-gray-700">"Sekolah adalah fase 'penyamaran' kalian. Mungkin sekarang kalian merasa 'miskin' atau 'buang waktu' dibanding teman yang sudah kerja. Tapi ini adalah fase mengumpulkan <span class="text-orange-500 font-bold">Data & Strategi 📈</span>. Tanpa fase ini, kalian tidak akan pernah matang untuk memimpin kerajaan bisnis kalian nanti 💰."</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="text-center mb-6">
                                <h3 class="text-2xl font-black text-gray-800 flex items-center justify-center gap-2"><span>🏆</span> Jenjang Karir & Poin</h3>
                                <p class="text-gray-500 text-sm font-medium">Kumpulkan Poin untuk menaikkan status sosialmu!</p>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                                <div class="group bg-gradient-to-br from-white to-orange-50 p-4 rounded-2xl border border-orange-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all text-center">
                                    <div class="h-16 w-16 mx-auto mb-3 relative">
                                        <div class="absolute inset-0 bg-orange-400 rounded-full blur opacity-20 group-hover:opacity-40 transition"></div>
                                        <img src="{{ asset('img/bronze.png') }}" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition">
                                    </div>
                                    <h4 class="font-black text-xs text-amber-700 uppercase mb-1">Bronze</h4>
                                    <span class="block mt-2 text-[10px] bg-white border border-orange-200 text-orange-600 rounded-full py-0.5 font-bold">0-12 Poin</span>
                                </div>
                                <div class="group bg-gradient-to-br from-white to-gray-50 p-4 rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all text-center">
                                    <div class="h-16 w-16 mx-auto mb-3 relative">
                                        <div class="absolute inset-0 bg-gray-400 rounded-full blur opacity-20 group-hover:opacity-40 transition"></div>
                                        <img src="{{ asset('img/silver.png') }}" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition">
                                    </div>
                                    <h4 class="font-black text-xs text-gray-600 uppercase mb-1">Silver</h4>
                                    <span class="block mt-2 text-[10px] bg-white border border-gray-200 text-gray-600 rounded-full py-0.5 font-bold">13-24 Poin</span>
                                </div>
                                <div class="group bg-gradient-to-br from-yellow-50 to-amber-50 p-4 rounded-2xl border border-yellow-200 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all text-center ring-2 ring-yellow-400/30 transform scale-105 z-10">
                                    <div class="h-16 w-16 mx-auto mb-3 relative">
                                        <div class="absolute inset-0 bg-yellow-400 rounded-full blur opacity-30 group-hover:opacity-50 transition"></div>
                                        <img src="{{ asset('img/gold.png') }}" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition">
                                    </div>
                                    <h4 class="font-black text-xs text-yellow-700 uppercase mb-1">Gold</h4>
                                    <span class="block mt-2 text-[10px] bg-yellow-400 text-yellow-900 rounded-full py-0.5 font-bold shadow-sm">25-36 Poin</span>
                                </div>
                                <div class="group bg-gradient-to-br from-white to-cyan-50 p-4 rounded-2xl border border-cyan-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all text-center">
                                    <div class="h-16 w-16 mx-auto mb-3 relative">
                                        <div class="absolute inset-0 bg-cyan-400 rounded-full blur opacity-20 group-hover:opacity-40 transition"></div>
                                        <img src="{{ asset('img/platinum.png') }}" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition">
                                    </div>
                                    <h4 class="font-black text-xs text-cyan-700 uppercase mb-1">Platinum</h4>
                                    <span class="block mt-2 text-[10px] bg-white border border-cyan-200 text-cyan-600 rounded-full py-0.5 font-bold">37-48 Poin</span>
                                </div>
                                <div class="group bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-2xl border border-blue-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all text-center">
                                    <div class="h-16 w-16 mx-auto mb-3 relative">
                                        <div class="absolute inset-0 bg-blue-500 rounded-full blur opacity-20 group-hover:opacity-40 transition"></div>
                                        <img src="{{ asset('img/diamond.png') }}" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition">
                                    </div>
                                    <h4 class="font-black text-xs text-blue-700 uppercase mb-1">Diamond</h4>
                                    <span class="block mt-2 text-[10px] bg-white border border-blue-200 text-blue-600 rounded-full py-0.5 font-bold">49-60 Poin</span>
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

                @php
                    $allSiswa = \App\Models\User::where('role', 'siswa')->orderBy('points', 'desc')->get();
                    $userRank = 0;
                    foreach ($allSiswa as $index => $s) {
                        if ($s->id === Auth::id()) {
                            $userRank = $index + 1;
                            break;
                        }
                    }
                    $navShopItems = \App\Models\ShopItem::where('is_active', true)->orderBy('price', 'asc')->take(4)->get();
                    $raidEvent = \App\Models\RaidEvent::first();
                    $isEventFinished = $raidEvent && $raidEvent->status === 'finished';
                    foreach ($navShopItems as $item) {
                        $item->assigned_rank = $item->price;
                        $item->has_claimed = \App\Models\ShopTransaction::where('user_id', Auth::id())
                                                            ->where('shop_item_id', $item->id)
                                                            ->exists();
                    }
                @endphp

                <div class="relative bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-8 sm:px-10 overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-white/5 text-9xl font-black select-none">Poin</div>
                    <div class="relative z-10 flex flex-col sm:flex-row items-center gap-6">
                        {{-- Foto Profil Siswa --}}
                        <div class="h-20 w-20 rounded-full overflow-hidden border-4 border-yellow-400 shadow-lg shrink-0">
                            <img src="{{ Auth::user()->photo_url }}" class="h-full w-full object-cover">
                        </div>
                        {{-- Info Siswa --}}
                        <div class="text-center sm:text-left flex-1">
                            <h3 class="text-xl font-bold text-white leading-tight">{{ Auth::user()->name }}</h3>
                            <p class="text-blue-200 text-xs mt-1">Siswa PKBM Terang Mulia</p>
                            
                            <div class="flex flex-wrap gap-4 mt-3 justify-center sm:justify-start">
                                <div class="bg-white/10 px-3 py-1.5 rounded-xl border border-white/20 flex items-center gap-2">
                                    <span class="text-sm">🏆</span>
                                    <span class="text-xs font-bold text-white">Rank Leaderboard: <span class="text-yellow-400">#{{ $userRank }}</span></span>
                                </div>
                                <div class="bg-white/10 px-3 py-1.5 rounded-xl border border-white/20 flex items-center gap-2">
                                    <span class="text-sm">⭐</span>
                                    <span class="text-xs font-bold text-white">Total Poin: <span class="text-yellow-400">{{ Auth::user()->points }} Poin</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-10 bg-slate-50">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded text-sm font-bold flex items-center gap-2">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded text-sm font-bold flex items-center gap-2">{{ session('error') }}</div>
                    @endif

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                        <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2"><span>🎁</span> Pilihan Reward (Top 4 Leaderboard)</h3>
                        <span class="text-xs font-bold text-indigo-600 bg-indigo-100 px-3 py-1 rounded-full">Peringkat Anda saat ini: #{{ $userRank }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if(isset($navShopItems) && count($navShopItems) > 0)
                            @foreach($navShopItems as $item)
                                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 relative overflow-hidden group hover:border-blue-400 transition-all">
                                    <div class="flex gap-4">
                                        {{-- Gambar Reward --}}
                                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                            <img src="{{ filter_var($item->image, FILTER_VALIDATE_URL) ? $item->image : ($item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1593642532400-2682810df593?q=80&w=500&auto=format&fit=crop') }}" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                        {{-- Informasi Teks --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-start">
                                                <h4 class="font-bold text-slate-800 text-base truncate">{{ $item->name }}</h4>
                                                <div class="bg-indigo-100 text-indigo-700 font-black text-[10px] px-2 py-0.5 rounded-lg shrink-0 ml-2">Rank {{ $item->assigned_rank }}</div>
                                            </div>
                                            <p class="text-slate-500 text-xs mt-1 leading-relaxed break-words">{{ $item->description }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <div></div>
                                        <form action="{{ route('siswa.shop.buy', $item->id) }}" method="POST">
                                            @csrf
                                            @if(!$isEventFinished)
                                                <button type="button" disabled class="text-slate-400 text-xs font-bold py-2 px-4 rounded-lg bg-slate-200 cursor-not-allowed">
                                                    Klaim Reward 🎁
                                                </button>
                                            @elseif($item->has_claimed)
                                                <button type="button" disabled class="text-white text-xs font-bold py-2 px-4 rounded-lg bg-green-500/50 cursor-not-allowed">
                                                    Sudah Diklaim ✅
                                                </button>
                                            @elseif($userRank === $item->assigned_rank)
                                                <button type="submit" class="text-white text-xs font-bold py-2 px-4 rounded-lg bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">
                                                    Klaim Reward 🎁
                                                </button>
                                            @else
                                                <button type="button" disabled class="text-white text-xs font-bold py-2 px-4 rounded-lg bg-gray-400 cursor-not-allowed">
                                                    Bukan Peringkat {{ $item->assigned_rank }} 🔒
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-2 text-center py-8 text-gray-400">Belum ada reward di bursa. Tunggu Guru mengisinya ya! 🦁</div>
                        @endif
                    </div>
                    <div class="mt-8 text-center"><p class="text-xs text-slate-400 italic">*Penukaran aset hanya dapat dilakukan saat jam sekolah dengan persetujuan Admin/Guru.</p></div>
                </div>
            </div>
        </div>
    </div>

    </div>
</div>

<script>
    function playCoinSound() {
        try {
            // Memutar file audio kustom yang dikirimkan oleh User (coin.mp3)
            const audio = new Audio("{{ asset('audio/coin.mp3') }}");
            audio.play().catch(e => console.log("Playback blocked by browser autoplay policy:", e));
        } catch (e) {
            console.warn("Audio playback error:", e);
        }
    }
</script>
