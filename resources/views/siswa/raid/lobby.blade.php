<x-app-layout>
    <div class="min-h-screen bg-slate-900 text-white p-6 flex flex-col items-center justify-center relative overflow-hidden">

        {{-- Background Effect --}}
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/20 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="relative z-10 w-full max-w-5xl">

            {{-- HEADER ROOM --}}
            <div class="text-center mb-10">
                <span class="inline-block py-1 px-3 rounded bg-yellow-500/20 text-yellow-400 text-xs font-bold tracking-widest border border-yellow-500/50 mb-4 animate-pulse">
                    🟢 STATUS: LOBBY (MENUNGGU HOST)
                </span>

                <div class="flex flex-col items-center justify-center mb-6">
                    {{-- Avatar Boss --}}
                    <div class="relative w-32 h-32 md:w-40 md:h-40 mb-4 group">
                        <div class="absolute inset-0 bg-red-600 rounded-full blur-xl opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                        <img src="{{ asset('img/bos_mafia.png') }}" alt="Boss Mafia" class="w-full h-full object-cover rounded-full border-4 border-red-600 shadow-[0_0_20px_rgba(220,38,38,0.5)] transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-red-600 text-white text-[10px] font-bold px-3 py-0.5 rounded-full border border-red-400 shadow-sm whitespace-nowrap tracking-wider">
                            TARGET UTAMA
                        </div>
                    </div>

                    <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter drop-shadow-2xl mb-2">
                        {{ $event->mafia_name ?? 'MAFIA BOSS' }}
                    </h1>

                    {{-- HP Bar Boss (Hanya Tampilan, Tidak Bisa Diedit Siswa) --}}
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

            {{-- PLAYER GRID --}}
            <div class="bg-black/40 backdrop-blur-md border border-white/10 rounded-3xl p-8 shadow-2xl">
                <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
                    <h3 class="font-bold text-xl flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        SQUAD MEMBERS
                    </h3>
                    <div class="text-xs text-slate-500 font-mono">● LIVE DATA</div>
                </div>

                <div id="player-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <div class="col-span-full text-center py-10 text-slate-500">Memuat data squad...</div>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-slate-500 text-sm animate-bounce">🚀 Menunggu Guru menekan tombol "MULAI PERANG"...</p>
            </div>

        </div>
    </div>

    {{-- SCRIPT KHUSUS SISWA --}}
    <script>
        function updateLobby() {
            // PERBAIKAN: Menggunakan route SISWA (siswa.raid.lobby_data)
            // Bukan guru.raid.get_monitor_data
            fetch("{{ route('siswa.raid.lobby_data') }}")
                .then(response => response.json())
                .then(data => {
                    // 1. Cek jika perang dimulai
                    if (data.status === 'live') {
                        window.location.reload();
                        return;
                    }

                    // 2. Update HP Bar (Agar siswa bisa lihat HP Boss di lobby)
                    if(data.total_hp > 0) {
                        let percent = (data.current_hp / data.total_hp) * 100;
                        if(document.getElementById('hp-bar')) {
                            document.getElementById('hp-bar').style.width = percent + "%";
                            document.getElementById('hp-text').innerText = data.current_hp + " / " + data.total_hp + " HP";
                        }
                    }

                    // 3. Render Pemain
                    let html = '';
                    if(data.players.length > 0){
                        data.players.forEach(player => {
                            // Cek apakah ada foto profil di objek user
                            let photoUrl = player.user.photo_url || `https://ui-avatars.com/api/?name=${player.user.name}&background=random&color=fff`;

                            html += `
                                <div class="group relative bg-slate-800 border-2 border-slate-700 rounded-xl p-4 flex flex-col items-center transition-all hover:border-yellow-500 hover:bg-slate-700 hover:-translate-y-1">
                                    <div class="relative">
                                        <img src="${photoUrl}?t=${new Date().getTime()}"
                                             class="w-16 h-16 rounded-full mb-3 border-2 border-white shadow-lg object-cover">
                                        <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-slate-800 rounded-full animate-pulse"></span>
                                    </div>
                                    <span class="font-bold text-sm text-white truncate w-full text-center">${player.user.name}</span>
                                    <span class="text-[10px] text-slate-400 font-mono mt-1 bg-black/30 px-2 rounded">READY</span>
                                </div>
                            `;
                        });
                    } else {
                        html = '<div class="col-span-full text-center text-gray-500 italic py-8">Belum ada pasukan lain yang bergabung.</div>';
                    }

                    document.getElementById('player-grid').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        }

        // Jalankan update pertama kali
        updateLobby();
        // Update setiap 3 detik
        setInterval(updateLobby, 3000);
    </script>
</x-app-layout>
