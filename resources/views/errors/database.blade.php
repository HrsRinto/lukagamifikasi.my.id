<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-8 text-center border-t-8 border-red-500">
        <div class="text-6xl mb-4">🗄️</div>
        <h1 class="text-2xl font-black text-slate-800 mb-2">Database Belum Siap</h1>
        <p class="text-slate-600 mb-6 leading-relaxed">
            {{ $message ?? 'Ada masalah saat mengakses database. Kemungkinan besar tabel belum dibuat.' }}
        </p>
        <div class="bg-slate-100 p-4 rounded-xl text-left mb-6">
            <p class="text-xs font-bold text-slate-400 uppercase mb-2">Solusi:</p>
            <ul class="text-sm text-slate-700 space-y-2 list-disc pl-4">
                <li>Buka terminal Anda.</li>
                <li>Jalankan perintah: <code class="bg-white px-1 py-0.5 rounded font-mono text-red-600">php artisan migrate</code></li>
                <li>Jika di Vercel, pastikan DB_HOST sudah benar.</li>
            </ul>
        </div>
        <a href="/" class="inline-block bg-slate-800 text-white font-bold px-8 py-3 rounded-full hover:bg-slate-700 transition">
            Kembali ke Dashboard
        </a>
    </div>
</body>
</html>
