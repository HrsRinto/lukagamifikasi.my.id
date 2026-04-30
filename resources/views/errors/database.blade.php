<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Belum Siap</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center p-6">
    <div class="max-w-xl w-full bg-slate-800 rounded-3xl p-8 shadow-2xl border border-slate-700 text-center">
        <span class="text-6xl mb-6 block">⚠️</span>
        <h1 class="text-2xl font-bold mb-4">Koneksi Database Bermasalah</h1>
        <p class="text-slate-400 mb-6 leading-relaxed">
            Sistem mendeteksi ada tabel yang belum siap. Hal ini umum terjadi pada deployment baru.
        </p>
        
        <div class="bg-black/50 p-4 rounded-xl text-left mb-6 overflow-x-auto border border-red-500/20">
            <p class="text-red-400 font-mono text-xs">{{ $error_detail ?? 'Detail error tidak tersedia' }}</p>
        </div>

        <div class="flex flex-col gap-3">
            <a href="/admin/repair-db" class="w-full py-3 bg-blue-600 hover:bg-blue-700 rounded-xl font-bold transition">
                Coba Perbaiki Otomatis 🛠️
            </a>
            <a href="/dashboard" class="w-full py-3 bg-slate-700 hover:bg-slate-600 rounded-xl font-bold transition">
                Kembali ke Dashboard
            </a>
        </div>
        <p class="text-[10px] text-slate-500 mt-6 uppercase tracking-widest">Saran: Pastikan pengaturan database di .env atau Vercel sudah sesuai dengan TiDB Cloud Anda.</p>
    </div>
</body>
</html>
