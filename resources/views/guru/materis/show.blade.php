<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Kelola Modul: {{ $materi->title }}</h2>
            <a href="{{ route('materis.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-bold">&larr; Kembali ke Daftar</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- BAGIAN 1: EDIT VIDEO & MATERI --}}
            <div class="bg-white p-6 shadow-sm rounded-lg border-l-4 border-blue-500">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span>📹</span> Edit Informasi Materi & Video
                </h3>
                
                <form action="{{ route('materis.update', $materi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Judul Materi</label>
                            <input type="text" name="title" value="{{ $materi->title }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Link Youtube</label>
                            <input type="text" name="video_url" value="{{ $materi->video_url }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500">{{ $materi->description }}</textarea>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 font-bold text-sm">Update Data Materi</button>
                    </div>
                </form>
            </div>

            {{-- BAGIAN 2: DAFTAR SOAL (CRUD SOAL) --}}
            <div class="bg-white p-6 shadow-sm rounded-lg border-l-4 border-indigo-500">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <span>📝</span> Daftar Soal ({{ $materi->soals->count() }}/15)
                    </h3>
                    
                    @if($materi->soals->count() < 15)
                        {{-- Tombol Tambah Soal (Hanya muncul jika < 15) --}}
                        <a href="{{ route('soals.create', ['materi_id' => $materi->id]) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow flex items-center gap-2 text-sm">
                            + Tambah Soal Baru
                        </a>
                    @else
                        <span class="text-green-600 font-bold bg-green-100 px-3 py-1 rounded text-sm">Soal Lengkap (15/15)</span>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left">No</th>
                                <th class="px-4 py-2 text-left w-1/2">Pertanyaan</th>
                                <th class="px-4 py-2 text-center">Level</th>
                                <th class="px-4 py-2 text-center">Kunci</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($materi->soals as $index => $soal)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-bold">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">{{ Str::limit($soal->question, 60) }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        {{ $soal->kategori == 'easy' ? 'bg-green-100 text-green-700' : 
                                          ($soal->kategori == 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($soal->kategori) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-blue-600">{{ $soal->correct_answer }}</td>
                                <td class="px-4 py-3 text-center flex justify-center gap-2">
                                    {{-- Edit Soal --}}
                                    <a href="{{ route('soals.edit', $soal->id) }}" class="text-yellow-600 hover:text-yellow-800">✏️</a>
                                    
                                    {{-- Hapus Soal --}}
                                    <form action="{{ route('soals.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($materi->soals->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-400">Belum ada soal. Silakan tambah soal baru.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TOMBOL BAHAYA (HAPUS SATU MODUL FULL) --}}
            <div class="mt-8 border-t pt-6 text-right">
                <form action="{{ route('materis.destroy', $materi->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus Materi ini akan menghapus Video DAN SEMUA SOAL di dalamnya. Yakin?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-xs underline">
                        Hapus Modul Ini Secara Permanen
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>