<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-[#0f172a] flex items-center justify-center min-h-screen p-4 overflow-hidden">
    {{-- Animated Background Blobs --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none opacity-20">
        <div class="absolute -top-[10%] -left-[10%] w-[400px] h-[400px] bg-blue-600 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[400px] h-[400px] bg-purple-600 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-2xl w-full bg-white/10 backdrop-blur-xl rounded-[40px] shadow-2xl p-8 text-center border border-white/20 relative z-10 animate-fade-in">
        <div class="w-24 h-24 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-6 border border-red-500/30">
            <span class="text-5xl">⚠️</span>
        </div>
        
        <h1 class="text-3xl font-black text-white mb-3 tracking-tight">Koneksi Database Bermasalah</h1>
        <p class="text-slate-300 mb-8 leading-relaxed text-sm">
            {{ $message ?? 'Sistem mendeteksi ada tabel atau data yang belum siap di database Anda.' }}
        </p>

        @if(isset($error_detail))
        <div class="bg-black/40 rounded-2xl p-4 mb-8 text-left border border-white/10">
            <p class="text-[10px] font-bold text-red-400 uppercase tracking-widest mb-2">Detail Error:</p>
            <code class="text-xs text-red-300/90 font-mono break-all leading-tight">
                {{ $error_detail }}
            </code>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('admin.repair-db') }}" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold px-8 py-4 rounded-2xl hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-1 active:scale-95">
                Coba Perbaiki Otomatis 🛠️
            </a>
            <a href="/" class="flex-1 bg-white/10 text-white font-bold px-8 py-4 rounded-2xl hover:bg-white/20 transition-all border border-white/10">
                Kembali ke Dashboard
            </a>
        </div>

        <p class="mt-8 text-[10px] text-slate-500 font-medium">
            Saran: Pastikan pengaturan database di .env atau Vercel sudah sesuai dengan TiDB Cloud Anda.
        </p>
    </div>
</body>
</html>
