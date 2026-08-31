<x-app-layout class="bg-slate-50">
    <x-slot name="header">
        <div class="flex justify-between items-center py-2">
            <h2 class="font-black text-xl text-slate-800 tracking-tight">Kelola Modul: {{ $materi->title }}</h2>
            <a href="{{ route('materis.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-650 font-bold text-sm transition-colors duration-200">
                <svg width="16" height="16" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                </svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- BAGIAN 1: EDIT VIDEO & MATERI --}}
            <div class="bg-white p-8 shadow-sm rounded-3xl border border-slate-150 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-600"></div>
                
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-3">
                    <span class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg width="20" height="20" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </span> 
                    <span>Edit Informasi Materi & Video</span>
                </h3>
                
                @if (session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-2xl text-sm font-semibold border-l-4 border-emerald-500 shadow-sm animate-fade-in-up">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 text-rose-700 rounded-2xl text-sm font-semibold border-l-4 border-rose-500 shadow-sm animate-fade-in-up">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('materis.update', $materi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Judul Materi</label>
                            <input type="text" name="title" value="{{ $materi->title }}" class="w-full border border-slate-200 rounded-2xl py-3 px-4 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring focus:ring-indigo-200/50 transition-all duration-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Link Youtube</label>
                            <input type="text" name="video_url" value="{{ $materi->video_url }}" class="w-full border border-slate-200 rounded-2xl py-3 px-4 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring focus:ring-indigo-200/50 transition-all duration-200 text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Deskripsi</label>
                            <textarea name="description" rows="2" class="w-full border border-slate-200 rounded-2xl py-3 px-4 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring focus:ring-indigo-200/50 transition-all duration-200 text-sm">{{ $materi->description }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6 text-right">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-md transition-all duration-200">
                            Update Data Materi
                        </button>
                    </div>
                </form>
            </div>

            {{-- BAGIAN 2: DAFTAR SOAL (CRUD SOAL) --}}
            <div class="bg-white p-8 shadow-sm rounded-3xl border border-slate-150 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-600"></div>

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">
                        <span class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                            <svg width="20" height="20" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </span>
                        <span>Daftar Soal ({{ $materi->soals->count() }}/15)</span>
                    </h3>
                    
                    @if($materi->soals->count() < 15)
                        {{-- Tombol Tambah Soal (Hanya muncul jika < 15) --}}
                        <a href="{{ route('soals.create', ['materi_id' => $materi->id]) }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-2xl shadow-md transition-all duration-200 text-sm">
                            <svg width="18" height="18" class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                            </svg>
                            <span>Tambah Soal Baru</span>
                        </a>
                    @else
                        <span class="inline-flex items-center gap-2 text-emerald-700 font-bold bg-emerald-50 border border-emerald-150 px-4 py-2 rounded-2xl text-sm">
                            <svg width="16" height="16" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Soal Lengkap (15/15)</span>
                        </span>
                    @endif
                </div>

                <div class="overflow-hidden border border-slate-150 rounded-2xl">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-50 text-slate-500 border-b border-slate-150">
                                <tr>
                                    <th class="px-5 py-3 text-left font-black text-xs uppercase tracking-wider">No</th>
                                    <th class="px-5 py-3 text-left font-black text-xs uppercase tracking-wider w-1/2">Pertanyaan</th>
                                    <th class="px-5 py-3 text-center font-black text-xs uppercase tracking-wider">Level</th>
                                    <th class="px-5 py-3 text-center font-black text-xs uppercase tracking-wider">Kunci</th>
                                    <th class="px-5 py-3 text-center font-black text-xs uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-150 bg-white">
                                @foreach($materi->soals as $index => $soal)
                                <tr class="hover:bg-slate-50/55 transition-colors">
                                    <td class="px-5 py-4 font-bold text-slate-800">{{ $index + 1 }}</td>
                                    <td class="px-5 py-4 text-slate-700 font-medium">{{ Str::limit($soal->question, 80) }}</td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="inline-block px-3 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border 
                                            {{ $soal->kategori == 'easy' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 
                                              ($soal->kategori == 'medium' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-rose-50 text-rose-700 border-rose-100') }}">
                                            {{ $soal->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center font-black text-indigo-650">{{ $soal->correct_answer }}</td>
                                    <td class="px-5 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Edit Soal --}}
                                            <a href="{{ route('soals.edit', $soal->id) }}" 
                                               class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-xl transition-colors duration-200" 
                                               title="Edit Soal">
                                                <svg width="16" height="16" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                                                </svg>
                                            </a>
                                            
                                            {{-- Hapus Soal --}}
                                            <form action="{{ route('soals.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')" class="inline">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-xl transition-colors duration-200" 
                                                        title="Hapus Soal">
                                                    <svg width="16" height="16" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @if($materi->soals->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-slate-400 font-semibold bg-slate-50/20">Belum ada soal. Silakan tambah soal baru.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TOMBOL BAHAYA (HAPUS SATU MODUL FULL) --}}
            <div class="mt-8 border-t border-slate-200 pt-6 text-right">
                <form action="{{ route('materis.destroy', $materi->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus Materi ini akan menghapus Video DAN SEMUA SOAL di dalamnya. Yakin?')">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold text-xs underline decoration-2 transition-colors duration-200">
                        Hapus Modul Ini Secara Permanen
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- Animasi --}}
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.35s ease-out forwards;
        }
    </style>
</x-app-layout>