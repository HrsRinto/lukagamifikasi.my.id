<x-app-layout>
    {{-- TAMBAHAN: SweetAlert2 & Youtube API Script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Helper PHP untuk ID YouTube --}}
    @php
        function getYoutubeId($url) {
            $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
            preg_match($pattern, $url, $matches);
            return isset($matches[1]) ? $matches[1] : null;
        }
        $videoId = getYoutubeId($materi->video_url);
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Belajar: ') . $materi->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Breadcrumb Navigasi --}}
            <nav class="flex mb-6 text-gray-500 text-sm font-medium" aria-label="Breadcrumb">
                <a href="{{ route('siswa.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">Materi Pembelajaran</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: VIDEO & KONTEN --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- 1. Video Player Card --}}
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                        <div class="aspect-w-16 aspect-h-9 bg-black relative">
                            @if($videoId)
                                {{-- Div Kosong untuk API YouTube --}}
                                <div id="youtube-player"></div>
                            @else
                                <div class="flex items-center justify-center h-full text-white">
                                    <p>Video tidak ditemukan atau URL salah.</p>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $materi->title }}</h1>
                            <div class="flex items-center text-sm text-gray-500 gap-4">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Video Pembelajaran
                                </span>
                                {{-- Tambahan Info Anti-Skip --}}
                                <span class="flex items-center gap-1 text-red-500 font-bold bg-red-50 px-2 py-0.5 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Anti-Skip Aktif
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Deskripsi Materi --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <h3 class="font-bold text-lg text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Ringkasan Materi
                        </h3>
                        <div class="prose max-w-none text-gray-600 leading-relaxed">
                            {!! nl2br(e($materi->description)) !!}
                        </div>
                    </div>

                </div>

                {{-- KOLOM KANAN: STATUS & PROGRESS --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- Card Status Penyelesaian --}}
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-t-4 border-blue-600 sticky top-6">
                        <h3 class="font-bold text-gray-800 mb-4">Status Belajar</h3>

                        @if($materi->sudah_nonton)
                            {{-- Jika SUDAH Selesai --}}
                            <div class="flex flex-col items-center text-center animate-pulse">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-600 mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="text-green-600 font-bold text-lg">Materi Selesai!</p>
                                <p class="text-gray-500 text-sm mb-4">Hebat! Kamu sudah menyelesaikan materi ini.</p>

                                <a href="{{ route('siswa.kuis.pre', $materi->id) }}" class="w-full inline-flex items-center justify-center bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-purple-500/30 transform transition hover:-translate-y-1">
                                    <span>Lanjut ke Kuis 🚀</span>
                                </a>
                            </div>
                        @else
                            {{-- Jika BELUM Selesai --}}
                            <div id="locked-section" class="text-center py-6 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50">
                                <div class="text-4xl mb-2">🔒</div>
                                <p class="text-gray-800 font-bold text-sm">Tombol Terkunci</p>
                                <p class="text-gray-500 text-xs mt-1 px-4">
                                    Tonton video sampai detik terakhir tanpa skip untuk membuka akses kuis.
                                </p>
                                <div class="mt-3 flex justify-center">
                                    <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                                        Menunggu Video
                                    </span>
                                </div>
                            </div>

                            <div id="unlocked-section" class="hidden">
                                <p class="text-green-600 text-sm font-bold mb-4 text-center">Video Selesai! Silakan konfirmasi.</p>
                                <form action="{{ route('siswa.materi.complete', $materi->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full group relative flex items-center justify-center gap-2 py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-blue-500/30 shadow-lg hover:shadow-blue-500/50 transform hover:-translate-y-1 animate-bounce">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Selesai & Buka Kuis
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden opacity-75">
                        <div class="bg-gray-50 px-6 py-3 border-b border-gray-100">
                            <h4 class="font-bold text-gray-700 text-sm uppercase tracking-wide">Langkah Selanjutnya</h4>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">Kuis Pemahaman</p>
                                    <p class="text-xs text-gray-500">Terkunci hingga video selesai</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Script CSS tambahan --}}
    <style>
        .aspect-w-16 { position: relative; padding-bottom: 56.25%; }
        #youtube-player { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
    </style>

    {{-- LOGIKA YOUTUBE API ANTI-SKIP --}}
    @if(!$materi->sudah_nonton && $videoId)
        <script>
            // Variabel Global
            var player;
            var maxTimeWatched = 0; // Menyimpan durasi terjauh yang sudah ditonton
            var checkInterval; // Interval pengecekan

            // 1. Muat API
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            // 2. Inisialisasi Player
            function onYouTubeIframeAPIReady() {
                player = new YT.Player('youtube-player', {
                    height: '100%',
                    width: '100%',
                    videoId: '{{ $videoId }}',
                    playerVars: {
                        'playsinline': 1,
                        'rel': 0,
                        'modestbranding': 1,
                        'disablekb': 1, // Matikan keyboard (panah kanan untuk skip)
                        'controls': 1   // Tetap tampilkan kontrol (Play/Pause) tapi kita pantau
                    },
                    events: {
                        'onStateChange': onPlayerStateChange
                    }
                });
            }

            // 3. Listener Status Video
            function onPlayerStateChange(event) {
                // Jika video diputar (PLAYING = 1)
                if (event.data == YT.PlayerState.PLAYING) {
                    // Mulai pengecekan tiap 1 detik
                    checkInterval = setInterval(checkProgress, 1000);
                }
                // Jika video selesai (ENDED = 0)
                else if (event.data == YT.PlayerState.ENDED) {
                    clearInterval(checkInterval);
                    videoFinished();
                }
                // Jika dipause/buffering, hentikan pengecekan sementara
                else {
                    clearInterval(checkInterval);
                }
            }

            // 4. Fungsi Pengecekan Anti-Skip
            function checkProgress() {
                var currentTime = player.getCurrentTime();

                // Toleransi lompatan kecil (misal buffering) = 2 detik
                if (currentTime > maxTimeWatched + 3) {
                    // Jika user melompat terlalu jauh ke depan
                    player.seekTo(maxTimeWatched, true); // Kembalikan ke posisi terakhir

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: '#fef2f2',
                        color: '#b91c1c'
                    });
                    Toast.fire({
                        icon: 'warning',
                        title: 'Dilarang Skip Video! 🚫',
                        text: 'Silakan tonton materinya secara berurutan.'
                    });
                } else {
                    // Update waktu terjauh
                    if (currentTime > maxTimeWatched) {
                        maxTimeWatched = currentTime;
                    }
                }
            }

            // 5. Aksi saat video selesai
            function videoFinished() {
                document.getElementById('locked-section').classList.add('hidden');

                const unlockedSection = document.getElementById('unlocked-section');
                unlockedSection.classList.remove('hidden');
                unlockedSection.classList.add('animate-fade-in-up');

                Swal.fire({
                    title: 'Video Selesai! 🌟',
                    text: 'Hebat! Sekarang tombol konfirmasi sudah terbuka.',
                    icon: 'success',
                    confirmButtonText: 'Oke',
                    timer: 3000
                });
            }
        </script>
    @endif

</x-app-layout>
