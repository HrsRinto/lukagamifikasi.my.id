<x-app-layout class="bg-gray-900">
    @php
        $myGlobalRank = '-';
        $myPointsGained = 0;
        foreach($leaderboard as $index => $u) {
            if ($u->id === Auth::id()) {
                $myGlobalRank = $index + 1;
                $myPointsGained = $u->event_total_points;
                break;
            }
        }
    @endphp

    <div class="min-h-screen bg-gray-900 text-white flex flex-col items-center justify-center p-4">
        <h1 class="text-5xl md:text-7xl font-black text-yellow-400 mb-4 tracking-wider drop-shadow-[0_4px_12px_rgba(250,204,21,0.4)] uppercase text-center">MISSION COMPLETE!</h1>
        <p class="text-xl md:text-2xl font-black text-red-500 uppercase tracking-wide mb-8 drop-shadow-[0_2px_4px_rgba(239,68,68,0.5)] text-center px-4">
            💥 Mafia "{{ $event->mafia_name }}" Telah Dikalahkan Dengan Gemilang! 💥
        </p>

        {{-- Ringkasan Hasil Siswa yang Login --}}
        <div class="bg-slate-800/90 border-2 border-yellow-400/50 rounded-3xl p-6 w-full max-w-2xl shadow-[0_20px_50px_rgba(250,204,21,0.15)] flex items-center gap-6 mb-6">
            <div class="h-20 w-20 rounded-full overflow-hidden border-4 border-yellow-400 shadow-lg shrink-0">
                <img src="{{ Auth::user()->photo_url }}" class="h-full w-full object-cover">
            </div>
            <div class="flex-1">
                <h4 class="font-extrabold text-xl text-white">Laporan Pertempuran: {{ Auth::user()->name }}</h4>
                <div class="flex flex-wrap gap-4 mt-3">
                    <div class="bg-white/10 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-200 border border-white/10 flex items-center gap-1.5">
                        🏆 Peringkat Kontribusi: <span class="text-yellow-400">#{{ $myGlobalRank }}</span>
                    </div>
                    <div class="bg-white/10 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-200 border border-white/10 flex items-center gap-1.5">
                        ⭐ Total Poin Anda: <span class="text-emerald-400">{{ Auth::user()->points + $myPointsGained }} Poin</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white text-gray-900 rounded-[2.5rem] p-8 w-full max-w-2xl shadow-2xl border-4 border-indigo-100">
            <h3 class="text-2xl md:text-3xl font-black mb-6 text-center border-b pb-4 text-indigo-900 flex items-center justify-center gap-2">
                <span>🏆</span> Peringkat Kontribusi
            </h3>

            <div class="space-y-4 max-h-[380px] overflow-y-auto pr-2">
                @foreach($leaderboard as $index => $u)
                    @php
                        $isMe = $u->id === Auth::id();
                        $rank = $index + 1;
                    @endphp
                    <div class="flex items-center justify-between p-4 rounded-2xl border-2 transition-all duration-300
                        {{ $isMe ? 'bg-indigo-50/80 border-indigo-500 shadow-md shadow-indigo-500/10' : '' }}
                        {{ !$isMe && $rank == 1 ? 'bg-yellow-50/50 border-yellow-300' : '' }}
                        {{ !$isMe && $rank == 2 ? 'bg-slate-50/50 border-slate-300' : '' }}
                        {{ !$isMe && $rank == 3 ? 'bg-amber-50/50 border-amber-300' : '' }}
                        {{ !$isMe && $rank > 3 ? 'bg-gray-50 border-gray-150' : '' }}">
                        
                        <div class="flex items-center gap-4">
                            {{-- Medali/Rank Badge --}}
                            <span class="font-black text-xl w-8 text-center
                                {{ $rank == 1 ? 'text-yellow-500 text-2xl' : '' }}
                                {{ $rank == 2 ? 'text-slate-400 text-2xl' : '' }}
                                {{ $rank == 3 ? 'text-amber-600 text-2xl' : '' }}
                                {{ $rank > 3 ? 'text-gray-400' : '' }}">
                                @if($rank == 1) 🥇 @elseif($rank == 2) 🥈 @elseif($rank == 3) 🥉 @else #{{ $rank }} @endif
                            </span>

                            {{-- Foto Siswa --}}
                            <div class="h-10 w-10 rounded-full overflow-hidden border border-slate-200 shrink-0">
                                <img src="{{ $u->photo_url }}" class="h-full w-full object-cover">
                            </div>

                            <div class="flex flex-col">
                                <span class="font-extrabold text-slate-800 text-base flex items-center gap-1.5">
                                    {{ $u->name }}
                                    @if($isMe)
                                        <span class="bg-indigo-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Kamu</span>
                                    @endif
                                </span>
                                <span class="text-xs text-slate-500 font-bold">
                                    Damage Pertempuran: <span class="text-slate-700 font-black">{{ $u->event_damage }} HP</span>
                                </span>
                            </div>
                        </div>

                        <div class="text-right">
                            <span class="block font-black text-xl text-indigo-950">+{{ $u->event_total_points }}</span>
                            <span class="text-[9px] text-slate-400 uppercase tracking-widest font-black">Poin Event</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-blue-500/30 transition transform hover:-translate-y-1 hover:scale-[1.02] active:scale-95 text-lg">
                    <span>Kembali ke Dashboard 🏠</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
