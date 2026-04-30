<x-app-layout>
    <div class="min-h-screen bg-slate-900 text-white p-6 flex flex-col items-center justify-center relative overflow-hidden">

        {{-- Background Effect --}}
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/20 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="relative z-10 w-full max-w-5xl">

            {{-- HEADER ROOM (BOSS INFO & STATUS) --}}
            <div class="text-center mb-8">

                <span id="status-badge" class="inline-block py-1 px-3 rounded bg-yellow-500/20 text-yellow-400 text-xs font-bold tracking-widest border border-yellow-500/50 mb-6 animate-pulse">
                    🟢 STATUS: LOBBY
                </span>

                {{-- BOSS AVATAR & HP BAR (Gabungan dari Monitor) --}}
                <div class="flex flex-col items-center justify-center mb-6">

                    {{-- Avatar Boss --}}
                    <div class="relative w-32 h-32 md:w-40 md:h-40 mb-4 group">
                        <div class="absolute inset-0 bg-red-600 rounded-full blur-xl opacity-20 group-hover:opacity-40 transition-opacity duration-500 animate-pulse"></div>
                        <img src="{{ asset('img/bos_mafia.png') }}"
                             alt="Boss Mafia"
                             class="w-full h-full object-cover rounded-full border-4 border-red-600 shadow-[0_0_20px_rgba(220,38,38,0.5)] transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-red-600 text-white text-[10px] font-bold px-3 py-0.5 rounded-full border border-red-400 shadow-sm whitespace-nowrap tracking-wider">
                            TARGET UTAMA
                        </div>
                    </div>

                    {{-- Nama Boss --}}
                    <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter drop-shadow-2xl mb-2">
                        {{ $event->mafia_name }}
                    </h1>

                    {{-- HP Bar Boss --}}
                    <div class="w-full max-w-md bg-black/50 h-6 rounded-full border border-slate-600 relative overflow-hidden shadow-lg mt-2">
                        <div id="hp-bar" class="h-full bg-gradient-to-r from-red-700 via-red-600 to-red-500 transition-all duration-500"
                             style="width: {{ ($event->total_hp > 0) ? ($event->current_hp / $event->total_hp) * 100 : 0 }}%"></div>
                        <div id="hp-text" class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-white uppercase tracking-widest text-shadow">
                            {{ $event->current_hp }} / {{ $event->total_hp }} HP
                        </div>
                    </div>

                    <p class="text-slate-400 mt-4 font-mono text-sm">Mission: Destroy the Boss & Loot XP</p>
                </div>
            </div>

            {{-- PLAYER GRID (PUBG STYLE - Tetap Dipertahankan) --}}
            <div class="bg-black/40 backdrop-blur-md border border-white/10 rounded-3xl p-6 md:p-8 shadow-2xl">
                <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
                    <h3 class="font-bold text-xl flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        SQUAD MEMBERS
                    </h3>
                    <div class="text-xs text-slate-500 font-mono animate-pulse">
                        ● LIVE DATA
                    </div>
                </div>

                {{-- Disini Avatar Pemain akan muncul lewat JS --}}
                <div id="player-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    {{-- Loading State --}}
                    <div class="col-span-full text-center py-10 text-slate-500 flex flex-col items-center">
                        <svg class="animate-spin h-8 w-8 text-blue-500 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Menghubungkan ke server...</span>
                    </div>
                </div>
            </div>

            {{-- INSTRUCTION --}}
            <div class="mt-8 text-center">
                <p class="text-slate-500 text-sm animate-bounce">
                    🚀 Menunggu Guru menekan tombol "MULAI PERANG"...
                </p>
            </div>

        </div>
    </div>

    {{-- SCRIPT AJAX LOBBY --}}
    <script>
        function updateMonitor() {
            fetch("{{ route('guru.raid.get_monitor_data') }}")
                .then(response => response.json())
                .then(data => {
                    // 1. Update Status Badge
                    const badge = document.getElementById('status-badge');
                    if (data.status === 'lobby') {
                        badge.innerHTML = '🟢 STATUS: LOBBY (WAITING)';
                        badge.className = "inline-block py-1 px-3 rounded bg-yellow-500/20 text-yellow-400 text-xs font-bold tracking-widest border border-yellow-500/50 mb-6 animate-pulse";
                    } else if (data.status === 'live') {
                        badge.innerHTML = '⚔️ STATUS: BATTLE LIVE';
                        badge.className = "inline-block py-1 px-3 rounded bg-red-500/20 text-red-500 text-xs font-bold tracking-widest border border-red-500/50 mb-6 animate-pulse";
                    } else if (data.status === 'finished') {
                        badge.innerHTML = '🏁 STATUS: FINISHED';
                        badge.className = "inline-block py-1 px-3 rounded bg-green-500/20 text-green-500 text-xs font-bold tracking-widest border border-green-500/50 mb-6";
                    }

                    // 2. Update Boss HP
                    if(data.total_hp > 0) {
                        let percent = (data.current_hp / data.total_hp) * 100;
                        document.getElementById('hp-bar').style.width = percent + "%";
                        document.getElementById('hp-text').innerText = data.current_hp + " / " + data.total_hp + " HP";
                    }

                    // 3. Render Participants
                    let html = '';
                    if(data.participants.length > 0){
                        data.participants.forEach(p => {
                            html += `
                                <div class="group relative bg-slate-800 border-2 border-slate-700 rounded-xl p-4 flex flex-col items-center transition-all hover:border-red-500 hover:bg-slate-700 hover:-translate-y-1">
                                    <div class="relative">
                                        <img src="${p.user.photo_url}?t=${new Date().getTime()}"
                                            class="w-16 h-16 rounded-full mb-3 border-2 border-white shadow-lg object-cover">
                                        <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-slate-800 rounded-full animate-pulse"></span>
                                    </div>
                                    <span class="font-bold text-sm text-white truncate w-full text-center">${p.user.name}</span>
                                    <div class="flex items-center gap-1 mt-1">
                                        <span class="text-[10px] text-red-400 font-black bg-red-500/10 px-2 rounded border border-red-500/20">${p.damage_dealt} DMG</span>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        html = '<div class="col-span-full text-center text-gray-500 italic py-8">Belum ada pasukan yang bergabung.</div>';
                    }

                    document.getElementById('player-grid').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        }

        // Panggil pertama kali
        updateMonitor();

        // Ulangi setiap 2 detik (Lebih cepat untuk Guru)
        setInterval(updateMonitor, 2000);
    </script>
</x-app-layout>
