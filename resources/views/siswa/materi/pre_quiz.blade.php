<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peraturan Kuis - {{ $materi->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Nunito', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    {{-- BACKGROUND DEKORASI --}}
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    </div>

    {{-- CARD UTAMA --}}
    <div class="relative z-10 w-full max-w-2xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/50 ring-1 ring-black/5 animate-fade-in-up">

        {{-- HEADER: JUDUL & MASKOT --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-center relative overflow-hidden">
            {{-- Pattern Overlay --}}
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

            <div class="relative z-10">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl mx-auto flex items-center justify-center text-4xl mb-4 shadow-lg">
                    📝
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight mb-1">
                    {{ $materi->judul }}
                </h1>
                <p class="text-blue-200 text-sm font-medium uppercase tracking-widest">Persiapan Kuis Gamifikasi</p>
            </div>
        </div>

        {{-- BODY: DAFTAR PERATURAN --}}
        <div class="p-8 md:p-10">
            <h3 class="text-center text-gray-800 font-bold text-lg mb-8 flex items-center justify-center gap-2">
                <span>⚠️</span> Baca Aturan Main Dulu Ya!
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Rule 1: Komposisi Soal --}}
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-blue-50 border border-blue-100 hover:shadow-md transition">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-lg">
                        15
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Total Soal</h4>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Kuis ini terdiri dari 15 butir soal pilihan ganda yang harus diselesaikan.</p>
                    </div>
                </div>

                {{-- Rule 2: Tingkat Kesulitan --}}
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-purple-50 border border-purple-100 hover:shadow-md transition">
                    <div class="flex-shrink-0 w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-lg">
                        📊
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">3 Level Kesulitan</h4>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                            <span class="font-bold text-green-600">5 Easy</span>,
                            <span class="font-bold text-yellow-600">5 Medium</span>,
                            <span class="font-bold text-red-600">5 Hard</span>.
                        </p>
                    </div>
                </div>

                {{-- Rule 3: Durasi Waktu --}}
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-orange-50 border border-orange-100 hover:shadow-md transition">
                    <div class="flex-shrink-0 w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-lg">
                        ⏳
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">1 Menit / Soal</h4>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Fokus! Jika waktu habis, sistem otomatis lanjut ke soal berikutnya.</p>
                    </div>
                </div>

                {{-- Rule 4: Kunci Jawaban --}}
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-red-50 border border-red-100 hover:shadow-md transition">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-lg">
                        🔒
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Tidak Bisa Kembali</h4>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Jawaban yang sudah dipilih <span class="font-bold text-red-600">tidak dapat diganti</span>. Pilih dengan bijak!</p>
                    </div>
                </div>

            </div>

            {{-- MOTIVASI BOX --}}
            <div class="mt-8 bg-gradient-to-r from-yellow-100 to-amber-100 border border-yellow-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="text-3xl animate-bounce">🐵</div>
                <div>
                    <h5 class="font-black text-yellow-800 text-sm uppercase tracking-wide">Pesan dari LUKA:</h5>
                    <p class="text-yellow-900 text-sm font-medium italic">"Jangan takut salah, takutlah jika tidak mencoba. Semangat mengejar asetmu!!"</p>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="mt-10 flex flex-col md:flex-row gap-4 justify-center">
                {{-- Tombol Batal --}}
                <a href="{{ route('siswa.dashboard') }}" class="px-8 py-3 rounded-xl border-2 border-gray-200 text-gray-500 font-bold hover:bg-gray-50 hover:text-gray-700 transition text-center">
                    Kembali
                </a>

                {{-- Tombol Mulai --}}
                {{-- Pastikan route ini mengarah ke file kuis.blade.php yang sebelumnya kita buat --}}
                <a href="{{ route('siswa.kuis.show', $materi->id) }}" class="px-10 py-3 rounded-xl bg-blue-600 text-white font-bold shadow-lg shadow-blue-500/40 hover:bg-blue-700 hover:shadow-blue-600/50 hover:-translate-y-1 transition text-center flex items-center justify-center gap-2">
                    <span>Mulai Kerjakan Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </a>
            </div>

        </div>
    </div>

</body>
</html>
