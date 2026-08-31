<x-app-layout class="bg-slate-900">
    {{-- CSS KHUSUS UNTUK ANIMASI (RINGAN) --}}
    <style>
        /* Animasi Boss Bernafas (Idle) */
        @keyframes breathe {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        .boss-idle {
            animation: breathe 3s infinite ease-in-out;
        }

        /* Animasi Kena Hit (Bergetar Merah) */
        @keyframes shake-red {
            0% { transform: translate(1px, 1px) rotate(0deg); filter: sepia(0); }
            10% { transform: translate(-1px, -2px) rotate(-1deg); filter: sepia(1) hue-rotate(-50deg) saturate(5); }
            20% { transform: translate(-3px, 0px) rotate(1deg); }
            30% { transform: translate(3px, 2px) rotate(0deg); }
            40% { transform: translate(1px, -1px) rotate(1deg); }
            50% { transform: translate(-1px, 2px) rotate(-1deg); }
            60% { transform: translate(-3px, 1px) rotate(0deg); }
            100% { transform: translate(1px, -2px) rotate(-1deg); filter: sepia(0); }
        }
        .boss-hit {
            animation: shake-red 0.5s;
        }

        /* Animasi Angka Damage Melayang */
        @keyframes floatUp {
            0% { opacity: 1; transform: translateY(0) scale(1); }
            100% { opacity: 0; transform: translateY(-50px) scale(1.5); }
        }
        .damage-text {
            position: absolute;
            color: #ffcc00; /* Warna Emas */
            font-weight: 900;
            font-size: 2rem;
            text-shadow: 2px 2px 0 #000;
            pointer-events: none;
            animation: floatUp 1s ease-out forwards;
            z-index: 50;
        }

        /* Animasi Miss (Salah) */
        @keyframes shake-screen {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .screen-shake {
            animation: shake-screen 0.3s;
        }
    </style>

    <div id="game-container" class="min-h-screen bg-slate-900 text-white p-4 relative overflow-hidden font-sans flex flex-col items-center">

        {{-- Background Effect --}}
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-30 pointer-events-none"></div>

        {{-- BOSS SECTION --}}
        <div class="relative z-10 w-full max-w-3xl mt-4 mb-6 text-center">

            {{-- 1. AVATAR BOSS (UPDATED: GAMBAR LOKAL) --}}
            <div class="relative w-40 h-40 mx-auto mb-4">
                {{-- Container Gambar Boss --}}
                <div id="boss-avatar" class="w-full h-full bg-gray-800 rounded-full border-4 border-red-600 shadow-[0_0_30px_rgba(220,38,38,0.6)] overflow-hidden boss-idle relative">

                    {{-- PERUBAHAN DI SINI: Menggunakan asset lokal --}}
                    <img src="{{ asset('img/bos_mafia.png') }}"
                         alt="Boss Mafia" class="w-full h-full object-cover">

                    {{-- Efek Mata Merah (Overlay) --}}
                    <div class="absolute inset-0 bg-red-500 mix-blend-overlay opacity-0 transition-opacity duration-100" id="boss-flash"></div>
                </div>

                {{-- Tempat Muncul Angka Damage --}}
                <div id="damage-container" class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full pointer-events-none"></div>
            </div>

            {{-- 2. HP BAR --}}
            <div class="flex justify-between items-end px-4 mb-2">
                <h2 class="text-xl font-black text-white uppercase italic tracking-wider drop-shadow-md">{{ $event->mafia_name }}</h2>
                <span id="boss-hp-text" class="font-mono font-bold text-yellow-400 text-lg">{{ $event->current_hp }} / {{ $event->total_hp }} HP</span>
            </div>

            <div class="w-full bg-black/60 h-8 rounded-full border-2 border-slate-600 relative overflow-hidden shadow-lg">
                <div id="boss-hp-bar" class="h-full bg-gradient-to-r from-red-600 to-rose-500 transition-all duration-300 ease-out flex items-center justify-end pr-2"
                     style="width: {{ ($event->current_hp / $event->total_hp) * 100 }}%">
                     <div class="h-full w-1 bg-white/50 blur-[2px]"></div> {{-- Kilau Bar --}}
                </div>
            </div>
        </div>

        {{-- AREA SOAL --}}
        <div id="quiz-area" class="w-full max-w-5xl bg-white text-gray-900 rounded-3xl shadow-2xl p-6 relative z-10 border-b-8 border-gray-300 transition-transform duration-200">

            {{-- Header Soal --}}
            <div class="flex justify-between items-center mb-6 pb-4 border-b-2 border-gray-100">
                <div class="flex items-center gap-2">
                    <span class="bg-red-100 text-red-600 font-black px-3 py-1 rounded text-xs uppercase tracking-wider">Misi Utama</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-400 font-bold uppercase">Waktu</span>
                    <span id="timer" class="font-mono font-black text-2xl text-red-600 bg-red-50 px-2 rounded w-12 text-center">{{ $event->timer_seconds ?? 30 }}</span>
                </div>
            </div>

            {{-- Main Layout: Kiri Soal, Kanan Opsi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                {{-- Pertanyaan --}}
                <div id="question-container" class="min-h-[120px] flex items-center bg-slate-50/80 p-5 rounded-2xl border border-slate-100 w-full">
                    <div id="question-text" class="text-lg md:text-xl font-bold text-gray-800 leading-relaxed w-full">
                        <div class="flex items-center gap-2 animate-pulse text-gray-400">
                            <svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span>Mengunduh data intelijen...</span>
                        </div>
                    </div>
                </div>

                {{-- Opsi Jawaban (2x2 Grid) --}}
                <div id="options-grid" class="grid grid-cols-1 sm:grid-cols-2 sm:grid-rows-2 sm:grid-flow-col gap-3">
                </div>
            </div>
        </div>

    </div>

    {{-- Script Game Logic & Animation --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentSoalId = null;
        let timerInterval;
        let totalHP = {{ $event->total_hp }};
        let currentHP = {{ $event->current_hp }};
        
        // Audio Effects
        const audioBenar = new Audio("{{ asset('audio/benar.mp3') }}");
        audioBenar.preload = "auto";
        const audioSalah = new Audio("{{ asset('audio/salah.mp3') }}");
        audioSalah.preload = "auto";

        // Unlock audio context on first user interaction to allow playing inside async fetch
        const unlockAudio = () => {
            audioBenar.muted = true;
            audioSalah.muted = true;

            audioBenar.play().then(() => {
                audioBenar.pause();
                audioBenar.muted = false;
                audioBenar.currentTime = 0;
            }).catch(e => console.log("Unlock audioBenar:", e));

            audioSalah.play().then(() => {
                audioSalah.pause();
                audioSalah.muted = false;
                audioSalah.currentTime = 0;
            }).catch(e => console.log("Unlock audioSalah:", e));
        };
        // Bind to multiple events with once: true
        document.addEventListener('click', unlockAudio, { once: true });
        document.addEventListener('touchstart', unlockAudio, { once: true });

        // --- FUNGSI EFEK VISUAL --- //

        function playHitEffect(damage = 1) {
            const bossAvatar = document.getElementById('boss-avatar');
            const damageContainer = document.getElementById('damage-container');
            const flash = document.getElementById('boss-flash');

            // 1. Shake Boss
            bossAvatar.classList.remove('boss-idle'); // Stop idle animation
            bossAvatar.classList.add('boss-hit');     // Start shake animation

            // 2. Flash Merah
            flash.style.opacity = '0.8';
            setTimeout(() => flash.style.opacity = '0', 100);

            // 3. Reset Animation
            setTimeout(() => {
                bossAvatar.classList.remove('boss-hit');
                bossAvatar.classList.add('boss-idle');
            }, 500);

            // 4. Floating Damage Text
            const damageEl = document.createElement('div');
            damageEl.classList.add('damage-text');
            damageEl.innerText = `-${damage} HP`;
            // Random posisi sedikit biar natural
            damageEl.style.left = (50 + (Math.random() * 40 - 20)) + '%';
            damageEl.style.top = '10%';

            damageContainer.appendChild(damageEl);

            // Hapus elemen damage setelah animasi selesai (1 detik)
            setTimeout(() => {
                damageEl.remove();
            }, 1000);
        }

        function playMissEffect() {
            const container = document.getElementById('game-container');
            container.classList.add('bg-red-900'); // Kilat merah di background
            document.body.classList.add('screen-shake'); // Getar layar

            setTimeout(() => {
                container.classList.remove('bg-red-900');
                document.body.classList.remove('screen-shake');
            }, 300);
        }

        // --- FUNGSI UTAMA GAME --- //

        function loadSoal() {
            fetch("{{ route('siswa.raid.get_soal') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'finished') {
                        window.location.reload();
                        return;
                    }

                    const soal = data.soal;
                    if(!soal) {
                        document.getElementById('question-text').innerText = "Menunggu soal berikutnya...";
                        return;
                    }

                    currentSoalId = soal.id;

                    // Efek Fade In Teks Soal
                    const qText = document.getElementById('question-text');
                    qText.style.opacity = 0;
                    qText.innerText = soal.pertanyaan;
                    setTimeout(() => qText.style.opacity = 1, 100); // Transisi halus
                    qText.style.transition = "opacity 0.3s";

                    let opts = [
                        {key: 'a', val: soal.opsi_a},
                        {key: 'b', val: soal.opsi_b},
                        {key: 'c', val: soal.opsi_c},
                        {key: 'd', val: soal.opsi_d}
                    ];

                    let html = '';
                    opts.forEach(opt => {
                        html += `
                        <button onclick="submitAnswer('${opt.key}')"
                            class="group relative w-full bg-slate-50 hover:bg-indigo-600 border-2 border-slate-200 hover:border-indigo-600 p-4 rounded-xl text-left transition-all duration-200 transform hover:-translate-y-1 hover:shadow-lg active:scale-95">
                            <div class="flex items-center gap-3">
                                <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-indigo-100 group-hover:bg-white text-indigo-700 group-hover:text-indigo-600 font-black rounded-lg transition-colors uppercase">
                                    ${opt.key}
                                </span>
                                <span class="font-bold text-gray-700 group-hover:text-white text-lg">${opt.val}</span>
                            </div>
                        </button>`;
                    });
                    document.getElementById('options-grid').innerHTML = html;

                    startTimer();
                });
        }

        function startTimer() {
            let timeLeft = {{ $event->timer_seconds ?? 30 }};
            const timerEl = document.getElementById('timer');
            timerEl.innerText = timeLeft;
            clearInterval(timerInterval);

            timerInterval = setInterval(() => {
                timeLeft--;
                timerEl.innerText = timeLeft;

                // Efek visual waktu mau habis (Merah berkedip)
                if(timeLeft <= 5) {
                    timerEl.classList.add('animate-ping', 'text-red-500');
                } else {
                    timerEl.classList.remove('animate-ping', 'text-red-500');
                }

                if(timeLeft <= 0) {
                    clearInterval(timerInterval);
                    audioSalah.currentTime = 0;
                    audioSalah.play().catch(e => console.log("Audio play error:", e));
                    playMissEffect(); // Efek salah/waktu habis
                    Swal.fire({
                        icon: 'warning',
                        title: 'Waktu Habis!',
                        timer: 1000,
                        showConfirmButton: false,
                        backdrop: false
                    });
                    loadSoal();
                }
            }, 1000);
        }

        function submitAnswer(answer) {
            clearInterval(timerInterval);

            // Kunci tombol agar tidak spam klik
            document.getElementById('options-grid').style.pointerEvents = 'none';
            document.getElementById('options-grid').style.opacity = '0.7';

            fetch("{{ route('siswa.raid.attack') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ soal_id: currentSoalId, jawaban: answer })
            })
            .then(res => res.json())
            .then(data => {
                if(data.result === 'hit' || data.result === 'kill') {
                    // Play audio benar
                    audioBenar.currentTime = 0;
                    audioBenar.play().catch(e => console.log("Audio play error:", e));
                    
                    // JALANKAN ANIMASI HIT
                    playHitEffect();

                    // Update UI HP Bar
                    let hpPercent = (data.hp / totalHP) * 100;
                    document.getElementById('boss-hp-text').innerText = data.hp + " / " + totalHP + " HP";
                    document.getElementById('boss-hp-bar').style.width = hpPercent + "%";

                    // Update local currentHP
                    currentHP = data.hp;

                    // Feedback Kecil (Toast)
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Tembakan Masuk! -1 HP'
                    })

                } else {
                    // Play audio salah
                    audioSalah.currentTime = 0;
                    audioSalah.play().catch(e => console.log("Audio play error:", e));

                    // JALANKAN ANIMASI MISS
                    playMissEffect();

                    Swal.fire({
                        icon: 'error',
                        title: 'Meleset!',
                        text: 'Jawaban salah.',
                        timer: 1000,
                        showConfirmButton: false,
                        backdrop: false
                    });
                }

                if(data.hp <= 0) {
                    setTimeout(() => window.location.reload(), 1000); // Tunggu animasi selesai
                } else {
                    // Buka kunci tombol & Lanjut soal
                    setTimeout(() => {
                        document.getElementById('options-grid').style.pointerEvents = 'auto';
                        document.getElementById('options-grid').style.opacity = '1';
                        loadSoal();
                    }, 1000); // Jeda biar siswa lihat efek dulu
                }
            });
        }

        // Mulai Game
        loadSoal();

        // Polling HP Boss untuk Sinkronisasi Real-time (Setiap 1.5 detik)
        function syncBossHP() {
            fetch("{{ route('siswa.raid.get_hp') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'live') {
                        window.location.reload();
                        return;
                    }

                    // Check if Boss HP decreased due to other students' hits
                    if (data.hp < currentHP) {
                        let damage = currentHP - data.hp;
                        playHitEffect(damage);
                        
                        // Play audio benar
                        audioBenar.currentTime = 0;
                        audioBenar.play().catch(e => console.log("Audio play error:", e));
                    }

                    // Update local currentHP and totalHP
                    currentHP = data.hp;
                    totalHP = data.total;

                    // Update UI HP Bar
                    let hpPercent = (currentHP / totalHP) * 100;
                    document.getElementById('boss-hp-text').innerText = currentHP + " / " + totalHP + " HP";
                    document.getElementById('boss-hp-bar').style.width = hpPercent + "%";
                });
        }

        setInterval(syncBossHP, 3000);
    </script>
</x-app-layout>
