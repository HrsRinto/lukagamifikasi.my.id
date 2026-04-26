<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kuis: {{ $materi->judul }} - Gamifikasi</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Mencegah seleksi teks agar siswa tidak mudah copy-paste soal */
        body { user-select: none; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 h-screen flex flex-col overflow-hidden">

    {{-- HEADER KHUSUS KUIS (Tanpa Navigasi Web) --}}
    <div class="bg-white shadow-md border-b border-gray-200 px-6 py-3 flex-shrink-0 z-50 relative">
        <div class="max-w-7xl mx-auto flex justify-between items-center">

            {{-- Kiri: Tombol Keluar & Judul --}}
            <div class="flex items-center gap-4">
                {{-- Tombol Keluar Darurat --}}
                <a href="{{ route('siswa.dashboard') }}" onclick="return confirm('Yakin ingin keluar? Progress akan hilang!')" class="text-gray-400 hover:text-red-500 transition tooltip" title="Keluar Kuis">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>

                <div class="flex flex-col border-l-2 border-gray-200 pl-4">
                    <h2 class="font-bold text-lg text-gray-800 leading-tight truncate max-w-xs md:max-w-md">
                        {{ $materi->judul }}
                    </h2>
                    <div class="flex items-center gap-2">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider" id="progress-text">Menyiapkan...</p>
                    </div>
                </div>
            </div>

            {{-- Kanan: TIMER --}}
            <div id="timer-container" class="flex flex-col items-center justify-center bg-blue-50 border-2 border-blue-100 px-5 py-1.5 rounded-xl shadow-sm min-w-[110px] transition-all duration-300">
                <span class="text-[9px] font-black text-blue-400 uppercase tracking-widest mb-0.5">SISA WAKTU</span>
                <div class="flex items-center gap-1.5">
                    <svg id="timer-icon" class="w-4 h-4 text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span id="timer-display" class="text-xl font-mono font-black text-gray-800 tracking-tight leading-none">60:00</span>
                </div>
            </div>
        </div>
    </div>

    {{-- AREA KUIS (Fullscreen Center) --}}
    <div class="flex-1 flex flex-col justify-center items-center p-4 relative overflow-y-auto bg-gray-50">

        {{-- Background Pattern Halus --}}
        <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="w-full max-w-4xl h-full flex flex-col justify-center relative z-10">

            {{-- Card Container --}}
            <div class="bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden flex flex-col max-h-[85vh] relative">

                {{-- LOADING SCREEN --}}
                <div id="loading-state" class="absolute inset-0 flex flex-col items-center justify-center bg-white z-50">
                    <div class="relative">
                        <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                        <div class="absolute inset-0 flex items-center justify-center font-bold text-blue-600 text-xs">Loading</div>
                    </div>
                    <p class="text-gray-500 font-medium mt-4 animate-pulse">Menyiapkan arena kuis...</p>
                </div>

                {{-- QUIZ CONTENT --}}
                <div id="quiz-content" class="hidden flex flex-col h-full">

                    {{-- 1. Bagian Soal (Fixed Header dalam Card) --}}
                    <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 md:px-10 py-6 border-b border-gray-200 flex-shrink-0">
                        <div class="flex items-start gap-5">
                            {{-- Nomor Soal --}}
                            <div class="flex-shrink-0">
                                <span class="block w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-blue-500/30 transform -rotate-3">
                                    <span id="question-number">1</span>
                                </span>
                            </div>

                            {{-- Teks Soal --}}
                            <div class="w-full pt-1">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-white bg-blue-400 px-2 py-0.5 rounded-md shadow-sm" id="difficulty-badge">EASY</span>
                                </div>
                                <h3 class="text-gray-800 font-bold text-lg md:text-2xl leading-snug" id="question-text">
                                    Memuat pertanyaan...
                                </h3>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Bagian Jawaban (Scrollable Area) --}}
                    <div class="p-6 md:p-8 overflow-y-auto flex-1 bg-white custom-scrollbar">
                        <div id="options-container" class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5 h-full content-center">
                            {{-- Opsi jawaban di-generate JS --}}
                        </div>
                    </div>

                    {{-- 3. Footer (Hanya Tombol Finish) --}}
                    <div id="footer-actions" class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end flex-shrink-0 hidden">
                        <button id="btn-finish" onclick="finishQuiz()" class="flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-green-500/30 transition transform hover:-translate-y-1 focus:outline-none ring-offset-2 ring-2 ring-transparent focus:ring-green-500">
                            <span>Kirim Semua Jawaban</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- FORM RAHASIA --}}
    <form id="submit-form" action="{{ route('siswa.kuis.submit', $materi->id) }}" method="POST" style="display: none;">
        @csrf
        <div id="answers-inputs"></div>
    </form>

    {{-- LOGIKA JS (SAMA SEPERTI SEBELUMNYA, DIPERBARUI UNTUK TAMPILAN BARU) --}}
    <script>
        const questions = @json($soals);
        const timePerQuestion = 60;

        let currentIndex = 0;
        let timerInterval;
        let timeLeft = timePerQuestion;
        let userAnswers = {};
        let isProcessing = false;

        document.addEventListener("DOMContentLoaded", function() {
            const loading = document.getElementById("loading-state");
            const content = document.getElementById("quiz-content");

            if (questions.length > 0) {
                setTimeout(() => {
                    loading.style.display = 'none';
                    content.classList.remove('hidden');
                    loadQuestion();
                }, 800); // Sedikit lebih lama biar transisi halus
            } else {
                loading.innerHTML = `
                    <div class="text-center p-8">
                        <div class="text-6xl mb-4">📭</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Soal</h3>
                        <p class="text-gray-500 mb-6">Guru belum menambahkan soal untuk materi ini.</p>
                        <a href="{{ route('siswa.dashboard') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">Kembali ke Dashboard</a>
                    </div>
                `;
            }
        });

        function loadQuestion() {
            clearInterval(timerInterval);
            timeLeft = timePerQuestion;
            isProcessing = false;

            let q = questions[currentIndex];

            // Update Header
            document.getElementById("question-number").innerText = currentIndex + 1;
            document.getElementById("progress-text").innerText = `SOAL ${currentIndex + 1} / ${questions.length}`;
            document.getElementById("question-text").innerText = q.pertanyaan || q.question || q.soal || "Teks soal tidak ditemukan";

            const badge = document.getElementById("difficulty-badge");
            const diff = q.difficulty || 'easy';
            badge.innerText = diff.toUpperCase();

            if(diff === 'hard') {
                badge.className = "text-[10px] font-black uppercase tracking-widest text-white bg-red-500 px-2 py-1 rounded shadow-sm shadow-red-200";
            } else if (diff === 'medium') {
                badge.className = "text-[10px] font-black uppercase tracking-widest text-white bg-yellow-500 px-2 py-1 rounded shadow-sm shadow-yellow-200";
            } else {
                badge.className = "text-[10px] font-black uppercase tracking-widest text-white bg-blue-500 px-2 py-1 rounded shadow-sm shadow-blue-200";
            }

            // Render Opsi
            const container = document.getElementById("options-container");
            container.innerHTML = "";

            let options = [
                { key: 'a', text: q.opsi_a || q.option_a },
                { key: 'b', text: q.opsi_b || q.option_b },
                { key: 'c', text: q.opsi_c || q.option_c },
                { key: 'd', text: q.opsi_d || q.option_d }
            ];

            options.forEach(opt => {
                let btn = document.createElement("div");
                // Style Modern Card untuk Opsi
                btn.className = "group flex items-center p-5 border-2 border-gray-100 rounded-2xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 option-card relative overflow-hidden h-full shadow-sm hover:shadow-md";
                btn.id = `option-${opt.key}`;

                let correctAnswer = q.correct_answer || q.kunci_jawaban;

                btn.onclick = () => handleAnswerClick(btn, opt.key, q.id, correctAnswer);

                btn.innerHTML = `
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-gray-100 text-gray-500 font-black text-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 radio-indicator z-10 shadow-inner">
                        ${opt.key.toUpperCase()}
                    </div>
                    <span class="ml-5 text-gray-700 font-bold text-lg z-10 leading-snug group-hover:text-blue-800 transition-colors">${opt.text}</span>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 transform scale-50 transition-all duration-300 feedback-icon"></div>
                `;

                container.appendChild(btn);
            });

            // Footer Logic
            const footer = document.getElementById("footer-actions");
            const btnFinish = document.getElementById("btn-finish");

            if (currentIndex === questions.length - 1) {
                footer.classList.remove("hidden");
                btnFinish.classList.remove("hidden");
            } else {
                footer.classList.add("hidden");
                btnFinish.classList.add("hidden");
            }

            startTimer();
        }

        function handleAnswerClick(element, selectedKey, questionId, correctKey) {
            if (isProcessing) return;
            isProcessing = true;
            clearInterval(timerInterval);

            userAnswers[questionId] = selectedKey;

            // Disable semua opsi
            document.querySelectorAll(".option-card").forEach(el => {
                el.classList.add("pointer-events-none", "opacity-50", "grayscale"); // Efek disable
                el.classList.remove("hover:bg-blue-50", "hover:border-blue-300", "shadow-sm", "hover:shadow-md");
            });

            // Highlight Opsi Pilihan User (Kembalikan opacity)
            element.classList.remove("opacity-50", "grayscale", "border-gray-100");
            element.classList.add("shadow-lg", "scale-[1.02]"); // Efek pop

            let isCorrect = (selectedKey.toLowerCase() === correctKey.toLowerCase());

            if (isCorrect) {
                // Style Hijau (Benar)
                element.classList.add("bg-green-50", "border-green-500");
                const indicator = element.querySelector(".radio-indicator");
                indicator.classList.remove("bg-gray-100", "text-gray-500", "group-hover:bg-blue-600");
                indicator.classList.add("bg-green-500", "text-white");
                indicator.innerHTML = "✓";

                // Alert Benar
                const Toast = Swal.mixin({
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 1500,
                    timerProgressBar: true, background: '#f0fdf4', color: '#15803d'
                });
                Toast.fire({ icon: 'success', title: 'Jawaban Benar!' });

            } else {
                // Style Merah (Salah) pada pilihan User
                element.classList.add("bg-red-50", "border-red-500");
                const indicator = element.querySelector(".radio-indicator");
                indicator.classList.remove("bg-gray-100", "text-gray-500", "group-hover:bg-blue-600");
                indicator.classList.add("bg-red-500", "text-white");
                indicator.innerHTML = "✕";

                // Highlight Jawaban Benar
                let correctElem = document.getElementById(`option-${correctKey.toLowerCase()}`);
                if(correctElem) {
                    correctElem.classList.remove("opacity-50", "grayscale", "border-gray-100");
                    correctElem.classList.add("bg-green-50", "border-green-500", "ring-2", "ring-green-200");
                    const correctInd = correctElem.querySelector(".radio-indicator");
                    correctInd.classList.remove("bg-gray-100", "text-gray-500");
                    correctInd.classList.add("bg-green-500", "text-white");
                    correctInd.innerHTML = "✓";
                }

                // Alert Salah
                Swal.fire({
                    icon: 'error',
                    title: 'Oops, Kurang Tepat!',
                    html: `Jawaban yang benar adalah <span class="font-bold text-green-600">${correctKey.toUpperCase()}</span>`,
                    timer: 2500,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,0,0.2)`
                });
            }

            // Auto Next
            setTimeout(() => {
                nextQuestion();
            }, isCorrect ? 1500 : 2500);
        }

        function nextQuestion() {
            currentIndex++;
            if (currentIndex < questions.length) {
                loadQuestion();
            } else {
                finishQuiz();
            }
        }

        function startTimer() {
            updateTimerDisplay();
            timerInterval = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Waktu Habis!',
                        text: 'Pindah ke soal berikutnya.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    isProcessing = true;
                    setTimeout(() => nextQuestion(), 1500);
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            let m = Math.floor(timeLeft / 60);
            let s = timeLeft % 60;
            document.getElementById("timer-display").innerText = `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;

            const container = document.getElementById("timer-container");
            const textDisplay = document.getElementById("timer-display");
            const icon = document.getElementById("timer-icon");

            if(timeLeft <= 10) {
                container.classList.remove("bg-blue-50", "border-blue-100");
                container.classList.add("bg-red-50", "border-red-500", "animate-pulse");
                textDisplay.classList.add("text-red-600");
                icon.classList.remove("text-blue-600");
                icon.classList.add("text-red-600");
            } else {
                container.classList.add("bg-blue-50", "border-blue-100");
                container.classList.remove("bg-red-50", "border-red-500", "animate-pulse");
                textDisplay.classList.remove("text-red-600");
                icon.classList.add("text-blue-600");
                icon.classList.remove("text-red-600");
            }
        }

        function finishQuiz() {
            clearInterval(timerInterval);

            Swal.fire({
                title: 'Kuis Selesai! 🎉',
                text: "Kerja bagus! Sistem akan menyimpan jawabanmu.",
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Lihat Hasil 🚀',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const inputsContainer = document.getElementById("answers-inputs");
                    inputsContainer.innerHTML = "";
                    for (let [soalId, jawaban] of Object.entries(userAnswers)) {
                        let input = document.createElement("input");
                        input.type = "hidden";
                        input.name = `jawaban[${soalId}]`;
                        input.value = jawaban;
                        inputsContainer.appendChild(input);
                    }
                    document.getElementById("submit-form").submit();
                }
            })
        }
    </script>
</body>
</html>
