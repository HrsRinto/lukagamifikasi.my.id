<x-app-layout>
    {{-- SCRIPT EKSTERNAL (Canvas Confetti untuk efek meriah) --}}
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    {{-- WRAPPER UTAMA --}}
    <div class="min-h-screen bg-gradient-to-br from-blue-600 to-indigo-900 font-sans text-gray-100 pb-20 relative overflow-hidden" id="main-wrapper">

        {{-- DEKORASI BACKGROUND (Fixed & Animated via CSS) --}}
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-[20%] right-[-10%] w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-[-10%] left-[20%] w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
            {{-- Partikel JS --}}
            <canvas id="particle-canvas" class="absolute inset-0 w-full h-full opacity-30"></canvas>
        </div>

        <div class="relative z-10">

            {{-- HEADER SECTION --}}
            <div class="pt-12 pb-10 text-center px-4">
                <h2 class="text-4xl md:text-5xl font-black mb-3 tracking-tight text-white drop-shadow-md flex justify-center items-center gap-2">
                    <span id="typewriter-text" data-text="Halo, {{ $user->name }}! 👋"></span>
                    {{-- Kursor akan hilang via JS --}}
                </h2>
                <p class="text-blue-100 text-lg font-medium opacity-0 animate-fade-in-up" style="animation-delay: 1s; animation-fill-mode: forwards;">Siap Berpetualang dengan LUKA?</p>
            </div>

            {{-- ============================================================ --}}
            {{-- STATS CARDS: RANK & XP --}}
            {{-- ============================================================ --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 animate-fade-in-up" style="animation-delay: 0.2s; animation-fill-mode: forwards;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">

                    {{-- CARD 1: RANK --}}
                    <div class="tilt-card relative overflow-hidden rounded-[2.5rem] bg-[#1e293b]/90 backdrop-blur-xl border border-white/10 p-8 shadow-2xl hover:border-blue-500/30 transition-all duration-500 group">
                        {{-- Efek Glow --}}
                        <div class="absolute -right-12 -top-12 w-40 h-40 bg-blue-500/20 rounded-full blur-[60px] group-hover:bg-blue-500/30 transition-all"></div>

                        <div class="relative z-10 flex items-center gap-6">
                            {{-- Icon Badge --}}
                            <div class="w-24 h-24 flex-shrink-0 drop-shadow-[0_10px_20px_rgba(0,0,0,0.5)]">
                                <img src="{{ $user->badge_image }}" alt="Rank Badge" class="w-full h-full object-contain floating-icon">
                            </div>

                            {{-- Info Text --}}
                            <div class="flex-1">
                                <h3 class="text-blue-300 text-[10px] font-bold uppercase tracking-[0.2em] mb-1">RANK SAAT INI</h3>
                                <span class="text-4xl md:text-5xl font-black text-white tracking-tight drop-shadow-md block mb-2">{{ $user->rank_label }}</span>
                                <div class="inline-flex items-center gap-2 bg-[#0f172a]/60 px-3 py-1.5 rounded-full border border-white/5 backdrop-blur-sm">
                                    <span class="text-[11px] text-gray-300 font-medium">Terus tingkatkan performamu!</span>
                                    <span class="text-xs">🚀</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: XP & PROGRESS --}}
                    <div class="tilt-card relative overflow-hidden rounded-[2.5rem] bg-[#1e293b]/90 backdrop-blur-xl border border-white/10 p-8 shadow-2xl hover:border-yellow-500/30 transition-all duration-500 group">
                        {{-- Efek Glow --}}
                        <div class="absolute -left-12 -bottom-12 w-40 h-40 bg-yellow-500/20 rounded-full blur-[60px] group-hover:bg-yellow-500/30 transition-all"></div>

                        <div class="relative z-10 flex flex-col justify-between h-full">
                            {{-- Top Section --}}
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h3 class="text-yellow-500/80 text-[10px] font-bold uppercase tracking-[0.2em] mb-1">TOTAL EXPERIENCE</h3>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-5xl md:text-6xl font-black text-white tracking-tighter counter-value drop-shadow-lg" data-target="{{ $user->points }}">0</span>
                                        <span class="text-xl font-bold text-yellow-500">XP</span>
                                    </div>
                                </div>

                                {{-- Logic PHP untuk Next Rank --}}
                                @php
                                    $points = $user->points;
                                    $nextRank = '';
                                    $targetPoints = 0;

                                    if ($points < 13) { $nextRank = 'Silver'; $targetPoints = 13; }
                                    elseif ($points < 25) { $nextRank = 'Gold'; $targetPoints = 25; }
                                    elseif ($points < 37) { $nextRank = 'Platinum'; $targetPoints = 37; }
                                    elseif ($points < 49) { $nextRank = 'Diamond'; $targetPoints = 49; }
                                    else { $nextRank = 'Max Rank'; $targetPoints = 100; }

                                    $needed = $targetPoints - $points;
                                    $percentage = ($nextRank == 'Max Rank') ? 100 : ($points / $targetPoints) * 100;
                                    if($percentage > 100) $percentage = 100;
                                @endphp

                                <div class="text-right">
                                    @if($nextRank != 'Max Rank')
                                        <span class="block text-2xl font-bold text-white">{{ $needed }}</span>
                                        <span class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">lagi ke <span class="text-yellow-400">{{ $nextRank }}</span></span>
                                    @else
                                        <span class="text-yellow-400 font-black text-lg">MAX RANK! 👑</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Bottom Section: Progress Bar --}}
                            <div class="w-full bg-[#0f172a] h-4 rounded-full p-0.5 border border-white/5 relative overflow-hidden shadow-inner">
                                <div class="progress-bar-fill h-full rounded-full relative flex items-center bg-gradient-to-r from-yellow-600 to-yellow-400 shadow-[0_0_15px_rgba(234,179,8,0.4)]"
                                     style="width: 0%;" data-width="{{ $percentage }}%">
                                    <div class="absolute top-0 left-0 w-full h-1/2 bg-white/20 rounded-t-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            {{-- NOTIFIKASI --}}
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
                    <div class="bg-green-500/90 backdrop-blur-md text-white p-4 rounded-2xl shadow-lg flex items-center gap-3 animate-bounce-in border border-green-400">
                        <div class="bg-white/20 p-2 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- MAIN CONTENT GRID --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

                {{-- SECTION 1: MODUL PEMBELAJARAN --}}
                <div class="scroll-reveal">
                    <div class="flex items-center mb-8">
                        <div class="bg-yellow-400 w-1.5 h-10 rounded-full mr-4 shadow-[0_0_15px_rgba(250,204,21,0.6)] animate-pulse"></div>
                        <div>
                            <h3 class="text-3xl font-black text-white">Modul Pembelajaran</h3>
                            <p class="text-blue-200 text-sm">Selesaikan misi untuk mendapatkan XP!</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($materis as $index => $materi)
                        {{-- PERUBAHAN: Menambahkan class 'tilt-card' di sini agar animasi bekerja --}}
                        <div class="scroll-reveal-card tilt-card group bg-white rounded-[2rem] shadow-xl overflow-hidden transform transition-all duration-300 hover:shadow-2xl relative flex flex-col h-full border border-white/10" style="transition-delay: {{ $index * 100 }}ms">

                            {{-- Thumbnail Video --}}
                            <div class="h-60 bg-gray-900 relative overflow-hidden flex-shrink-0">
                                {{-- Status Badge --}}
                                @if($materi->sudah_nonton)
                                    <div class="absolute top-4 right-4 bg-green-500 text-white text-[10px] font-black px-3 py-1.5 rounded-full shadow-lg z-20 flex items-center gap-1 tracking-wider uppercase">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        Selesai
                                    </div>
                                @else
                                    <div class="absolute top-4 right-4 bg-gray-800/90 backdrop-blur-sm text-gray-300 text-[10px] font-black px-3 py-1.5 rounded-full shadow-lg z-20 flex items-center gap-1 tracking-wider uppercase border border-white/10">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Terkunci
                                    </div>
                                @endif

                                <img src="https://img.youtube.com/vi/{{ $materi->youtube_id }}/hqdefault.jpg"
                                    class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-110 transition duration-700">

                                {{-- Play Overlay --}}
                                @php
                                    $destinationRoute = route('siswa.materi.show', $materi->id);
                                    $iconOverlay = '<svg class="w-8 h-8 text-white ml-1 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>';

                                    if ($materi->nilai_kuis !== null) {
                                        $destinationRoute = route('siswa.kuis.hasil', $materi->id);
                                        $iconOverlay = '<span class="text-3xl">🏆</span>';
                                    } elseif ($materi->sudah_nonton) {
                                        $destinationRoute = route('siswa.kuis.pre', $materi->id);
                                        $iconOverlay = '<span class="text-3xl">🚀</span>';
                                    }
                                @endphp

                                <a href="{{ $destinationRoute }}"
                                class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/30 transition duration-300">
                                    <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center border border-white/50 shadow-[0_0_20px_rgba(0,0,0,0.3)] group-hover:scale-110 transition duration-300 animate-pulse-slow">
                                        {!! $iconOverlay !!}
                                    </div>
                                </a>
                            </div>

                            <div class="p-8 flex-1 flex flex-col bg-white relative">
                                @if(!empty($materi->mapel))
                                    <span class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2 w-fit">{{ $materi->mapel }}</span>
                                @endif

                                <h3 class="font-black text-2xl text-gray-800 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors leading-tight">
                                    {{ $materi->title }}
                                </h3>

                                <p class="text-gray-500 text-sm mb-8 line-clamp-3 leading-relaxed">
                                    {{ $materi->description }}
                                </p>

                                <div class="mt-auto pt-4 border-t border-gray-100">
                                    @if($materi->nilai_kuis !== null)
                                        <a href="{{ route('siswa.kuis.hasil', $materi->id) }}"
                                        class="w-full inline-flex items-center justify-center bg-green-100 text-green-700 font-bold py-3.5 px-6 rounded-xl border border-green-200 hover:bg-green-200 transition transform active:scale-95">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span>Lihat Nilai</span>
                                        </a>
                                    @elseif($materi->sudah_nonton)
                                        <a href="{{ route('siswa.kuis.pre', $materi->id) }}"
                                        class="w-full inline-flex items-center justify-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-blue-500/30 transform transition hover:-translate-y-1 hover:shadow-xl active:scale-95">
                                            <span>Mulai Kuis</span>
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        </a>
                                    @else
                                        <div class="w-full inline-flex items-center justify-center bg-gray-50 text-gray-400 font-bold py-3.5 px-6 rounded-xl border border-gray-200 cursor-not-allowed">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            <span>Tonton Video Dulu</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- SECTION: BURSA PREVILESE (SHOP) --}}
                <div class="scroll-reveal">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <div class="bg-indigo-500 w-1.5 h-10 rounded-full mr-4 shadow-[0_0_15px_rgba(99,102,241,0.6)] animate-pulse"></div>
                            <div>
                                <h3 class="text-3xl font-black text-white uppercase tracking-tight">Bursa Previlese</h3>
                                <p class="text-blue-200 text-sm">Tukarkan XP kamu dengan keuntungan spesial!</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($shopItems as $item)
                        <div class="tilt-card group relative overflow-hidden rounded-[2.5rem] bg-[#1e293b]/80 backdrop-blur-xl border border-white/10 p-1 shadow-2xl transition-all duration-500 hover:shadow-indigo-500/20">
                            {{-- Image Container --}}
                            <div class="h-48 rounded-[2rem] overflow-hidden relative">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1593642532400-2682810df593?q=80&w=500&auto=format&fit=crop' }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#1e293b] via-transparent to-transparent opacity-60"></div>
                                
                                {{-- Stock Badge --}}
                                <div class="absolute top-4 left-4 bg-black/50 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1.5 rounded-full border border-white/20">
                                    STOK: {{ $item->stock }}
                                </div>
                            </div>

                            <div class="p-6">
                                <h4 class="text-xl font-bold text-white mb-2">{{ $item->name }}</h4>
                                <p class="text-gray-400 text-sm line-clamp-2 mb-6 h-10">{{ $item->description }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-2xl font-black text-yellow-400">{{ number_format($item->price) }}</span>
                                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">XP</span>
                                    </div>

                                    <form action="{{ route('siswa.shop.buy', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-indigo-600/20 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                                                {{ $user->points < $item->price || $item->stock <= 0 ? 'disabled' : '' }}>
                                            TUKAR
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full py-20 text-center bg-white/5 rounded-[2.5rem] border border-dashed border-white/20">
                            <span class="text-5xl mb-4 block">📦</span>
                            <h4 class="text-xl font-bold text-white opacity-50">Toko sedang tutup. Kembali lagi nanti!</h4>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- SECTION 2: LEADERBOARD TEASER --}}
                <div class="relative scroll-reveal">
                    <div class="bg-gray-900 rounded-t-[2.5rem] p-8 md:p-10 flex flex-col md:flex-row justify-between items-center relative overflow-hidden shadow-2xl border-b border-gray-800 transform hover:scale-[1.01] transition duration-500">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 animate-pulse"></div>

                        <div class="relative z-10 flex items-center gap-4 mb-4 md:mb-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20 rotate-3 animate-bounce-slow">
                                <span class="text-3xl">🏆</span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-white">Klasemen Kelas</h3>
                                <p class="text-gray-400 text-sm">Siapakah penguasa tahta minggu ini?</p>
                            </div>
                        </div>

                        <a href="{{ route('siswa.leaderboard') }}" class="relative z-10 bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-full text-sm font-bold transition flex items-center gap-2 shadow-lg shadow-indigo-500/30 group active:scale-95">
                            Buka Rahasia
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </div>

                    <div class="bg-white rounded-b-[2.5rem] shadow-2xl overflow-hidden p-4 sm:p-6 relative">
                        <div class="absolute top-0 left-0 w-full h-1/2 bg-gradient-to-b from-gray-100/50 to-transparent pointer-events-none z-0"></div>

                        <div class="flex flex-col space-y-3 relative z-10">
                            @foreach($leaderboard->take(4) as $index => $s)
                                @php $isTop3 = $index < 3; @endphp
                                <div class="flex items-center justify-between p-4 rounded-2xl transition-all duration-300 border hover:scale-[1.02] hover:shadow-md
                                            {{ $isTop3 ? 'bg-gray-50 border-gray-200' : 'bg-white border-gray-100' }}">

                                    <div class="flex items-center gap-4 sm:gap-6">
                                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-xl font-black text-lg shadow-sm
                                            {{ $index == 0 ? 'bg-yellow-400 text-yellow-900' :
                                            ($index == 1 ? 'bg-gray-300 text-gray-800' :
                                            ($index == 2 ? 'bg-orange-300 text-orange-900' : 'bg-gray-100 text-gray-400')) }}">
                                            {{ $index + 1 }}
                                        </div>

                                        @if($isTop3)
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center text-2xl shadow-inner animate-pulse">🤫</div>
                                                <div class="flex flex-col gap-1">
                                                    <div class="bg-gray-300 h-5 w-32 rounded animate-pulse"></div>
                                                    <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest bg-indigo-50 px-2 py-0.5 rounded w-fit">Top Secret</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="relative">
                                                <div class="w-12 h-12 rounded-full bg-gray-200 p-0.5 {{ $s->id == Auth::id() ? 'bg-gradient-to-br from-blue-400 to-indigo-500' : '' }}">
                                                    @if($s->profile_photo_path)
                                                        <img src="{{ asset('storage/' . $s->profile_photo_path) }}" class="w-full h-full rounded-full object-cover border-2 border-white">
                                                    @else
                                                        <div class="w-full h-full rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm border-2 border-white">{{ strtoupper(substr($s->name, 0, 2)) }}</div>
                                                    @endif
                                                </div>
                                                <img src="{{ $s->badge_image }}" class="absolute -bottom-1 -right-1 w-5 h-5 drop-shadow-md">
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-gray-800 text-base sm:text-lg line-clamp-1">{{ $s->name }}</span>
                                                    @if($s->id == Auth::id())
                                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-blue-600 text-white tracking-wider">YOU</span>
                                                    @endif
                                                </div>
                                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ $s->rank_label }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-right">
                                        @if($isTop3)
                                            <div class="bg-gray-200 h-6 w-16 rounded animate-pulse mb-1"></div>
                                            <span class="text-[10px] font-bold text-gray-300 uppercase tracking-wider">???</span>
                                        @else
                                            <span class="block font-black text-xl sm:text-2xl text-indigo-600">{{ number_format($s->points) }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">XP</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <p class="text-xs text-gray-400 italic">"Siapa yang berada di puncak? Klik tombol di atas untuk melihat!"</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="text-center mt-16 pb-8 border-t border-white/10 pt-8">
                <p class="text-blue-200 text-sm font-medium">Gamifikasi SMP Terang Mulia Purwokerto</p>
                <div class="flex justify-center gap-4 mt-4 opacity-70 hover:opacity-100 transition">
                    <a href="#" class="text-white/60 hover:text-white transition"><span class="text-xs font-bold tracking-widest">@STIKOMYOS</span></a>
                    <span class="text-white/30">•</span>
                    <a href="#" class="text-white/60 hover:text-white transition"><span class="text-xs font-bold tracking-widest">@HIRONIMUS</span></a>
                </div>
            </div>

        </div>
    </div>

    {{-- STYLE ANIMASI CSS --}}
    <style>
        /* Animasi Muncul (Fade In Up) */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }

        /* Animasi Bounce Slow */
        @keyframes bounceSlow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-slow { animation: bounceSlow 3s infinite ease-in-out; }

        /* Animasi Pulse Slow */
        @keyframes pulseSlow {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        .animate-pulse-slow { animation: pulseSlow 2s infinite; }

        /* Animasi Icon Melayang */
        .floating-icon { animation: bounceSlow 4s infinite ease-in-out; }

        /* Class bantu untuk Scroll Reveal */
        .scroll-reveal, .scroll-reveal-card { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.5, 0, 0, 1); }
        .reveal-visible { opacity: 1; transform: translateY(0); }

        /* Cursor untuk type effect */
        .cursor-blink { animation: blink 1s infinite; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
    </style>

    {{-- SCRIPT JAVASCRIPT ANIMASI --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // 1. EFEK KETIK (TYPEWRITER) DI HEADER
            const textElement = document.getElementById('typewriter-text');
            const textToType = textElement.getAttribute('data-text');
            textElement.innerText = '';
            let i = 0;
            function typeWriter() {
                if (i < textToType.length) {
                    textElement.innerHTML += textToType.charAt(i);
                    i++;
                    setTimeout(typeWriter, 50); // Kecepatan ketik
                } else {
                    // Tambahkan kursor kedip setelah selesai
                    textElement.innerHTML += '<span class="text-yellow-400 cursor-blink">|</span>';

                    // Hilangkan kursor setelah 2 detik
                    setTimeout(() => {
                        const cursor = document.querySelector('.cursor-blink');
                        if(cursor) cursor.style.display = 'none';
                    }, 2000);
                }
            }
            setTimeout(typeWriter, 500); // Delay awal

            // 2. CONFETTI EFFECT (Meledak saat load)
            const duration = 3 * 1000;
            const animationEnd = Date.now() + duration;
            const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

            function randomInRange(min, max) { return Math.random() * (max - min) + min; }

            const interval = setInterval(function() {
                const timeLeft = animationEnd - Date.now();
                if (timeLeft <= 0) return clearInterval(interval);
                const particleCount = 50 * (timeLeft / duration);

                // Confetti dari kiri dan kanan bawah
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
            }, 250);

            // 3. ANIMASI ANGKA (COUNT UP)
            const counters = document.querySelectorAll('.counter-value');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const duration = 2000; // 2 detik
                const increment = target / (duration / 16);

                let current = 0;
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.innerText = Math.ceil(current).toLocaleString();
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.innerText = target.toLocaleString();
                    }
                };
                updateCounter();
            });

            // 4. ANIMASI PROGRESS BAR
            const progressBar = document.querySelector('.progress-bar-fill');
            if(progressBar) {
                setTimeout(() => {
                    progressBar.style.width = progressBar.getAttribute('data-width');
                }, 500);
            }

            // 5. SCROLL REVEAL (Muncul saat discroll)
            const observerOptions = { threshold: 0.1 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.scroll-reveal, .scroll-reveal-card').forEach(el => observer.observe(el));

            // 6. EFEK TILT 3D PADA KARTU (Vanilla JS)
            // Class .tilt-card sekarang diterapkan ke Modul Pembelajaran juga
            const cards = document.querySelectorAll('.tilt-card');
            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    const rotateX = ((y - centerY) / centerY) * -10; // Max rotasi 10 deg
                    const rotateY = ((x - centerX) / centerX) * 10;

                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
                });
            });

            // 7. BACKGROUND PARTICLES (Simple Canvas)
            const canvas = document.getElementById('particle-canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            let particlesArray = [];
            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 3 + 1;
                    this.speedX = Math.random() * 1 - 0.5;
                    this.speedY = Math.random() * 1 - 0.5;
                }
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    if (this.size > 0.2) this.size -= 0.01; // Perlahan mengecil
                    if (this.size <= 0.3) { // Reset jika terlalu kecil
                        this.x = Math.random() * canvas.width;
                        this.y = Math.random() * canvas.height;
                        this.size = Math.random() * 3 + 1;
                    }
                }
                draw() {
                    ctx.fillStyle = 'rgba(255, 255, 255, 0.3)';
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            function initParticles() {
                for (let i = 0; i < 50; i++) { particlesArray.push(new Particle()); }
            }
            function handleParticles() {
                for (let i = 0; i < particlesArray.length; i++) {
                    particlesArray[i].update();
                    particlesArray[i].draw();
                }
            }
            function animateParticles() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                handleParticles();
                requestAnimationFrame(animateParticles);
            }
            initParticles();
            animateParticles();

            // Resize handle
            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        });
    </script>
</x-app-layout>
