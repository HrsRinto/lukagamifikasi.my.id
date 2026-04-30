<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-900 px-4">
        <div class="max-w-xl w-full bg-slate-800 rounded-[2.5rem] p-10 shadow-2xl border border-slate-700 text-center">
            <div class="w-24 h-24 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-8 border border-red-500/20">
                <span class="text-5xl">⚠️</span>
            </div>
            
            <h1 class="text-3xl font-black text-white mb-4">Masalah Database Terdeteksi</h1>
            <p class="text-slate-400 mb-8 leading-relaxed">
                {{ $message ?? 'Ada tabel yang belum siap di database TiDB Anda.' }}
            </p>

            @if(isset($error_detail))
                <div class="bg-black/50 p-4 rounded-2xl text-left mb-8 overflow-x-auto">
                    <p class="text-red-400 font-mono text-xs">{{ $error_detail }}</p>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/admin/repair-db') }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-lg shadow-blue-600/20">
                    Coba Perbaiki Otomatis 🛠️
                </a>
                <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-slate-700 hover:bg-slate-600 text-white font-bold rounded-xl transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
