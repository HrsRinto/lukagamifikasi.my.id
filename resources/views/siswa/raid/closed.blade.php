<x-app-layout>
    <div class="min-h-screen bg-gray-900 text-white flex flex-col items-center justify-center p-4">

        {{-- Ikon Gembok Besar --}}
        <div class="bg-gray-800 p-6 rounded-full mb-6 shadow-lg border-2 border-gray-700 animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>

        <h1 class="text-4xl font-black text-white mb-2 text-center uppercase tracking-widest">
            EVENT BELUM DIMULAI
        </h1>

        <p class="text-gray-400 text-center max-w-md mb-8">
            Pintu markas mafia masih terkunci. Tunggu instruksi dari Guru untuk membuka akses Lobby.
        </p>

        <a href="{{ route('siswa.dashboard') }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-500 rounded-full font-bold text-white transition transform hover:-translate-y-1 shadow-lg shadow-blue-600/30">
            Kembali ke Dashboard
        </a>

        {{-- Script Auto Refresh (Cek status setiap 5 detik agar siswa tau kalau lobby sudah buka) --}}
        <script>
            setInterval(() => {
                location.reload();
            }, 3000);
        </script>
    </div>
</x-app-layout>
