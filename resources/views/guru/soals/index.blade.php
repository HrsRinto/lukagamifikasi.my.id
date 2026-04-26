<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bank Soal Kuis</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Daftar Semua Soal</h3>
                        <a href="{{ route('soals.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                            + Buat Soal Baru
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-sm font-bold text-gray-700">Materi</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-bold text-gray-700">Pertanyaan</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-bold text-gray-700">Level</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-bold text-gray-700">Poin</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-bold text-gray-700">Kunci</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-bold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($soals as $soal)
                                    <tr class="hover:bg-gray-50 transition">
                                        {{-- 1. Tampilkan Nama Materi --}}
                                        <td class="py-3 px-4 border-b text-sm text-gray-600">
                                            <span class="font-bold text-blue-600">[ID: {{ $soal->materi_id }}]</span>
                                            <br>
                                            {{ $soal->materi->title ?? 'Materi dihapus' }}
                                        </td>

                                        {{-- 2. PENTING: Panggil 'question' (Bukan pertanyaan) --}}
                                        <td class="py-3 px-4 border-b text-sm text-gray-800">
                                            {{ Str::limit($soal->question, 50) }}
                                        </td>

                                        {{-- 3. Level --}}
                                        <td class="py-3 px-4 border-b text-center">
                                            <span class="px-2 py-1 rounded text-xs font-bold 
                                                {{ $soal->kategori == 'easy' ? 'bg-green-100 text-green-600' : 
                                                  ($soal->kategori == 'medium' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }}">
                                                {{ ucfirst($soal->kategori) }}
                                            </span>
                                        </td>

                                        {{-- 4. PENTING: Panggil 'points' (Bukan poin) --}}
                                        <td class="py-3 px-4 border-b text-center font-bold">
                                            {{ $soal->points }}
                                        </td>

                                        {{-- 5. PENTING: Panggil 'correct_answer' --}}
                                        <td class="py-3 px-4 border-b text-center font-bold text-blue-600">
                                            {{ $soal->correct_answer }}
                                        </td>

                                        <td class="py-3 px-4 border-b text-center">
                                            <form action="{{ route('soals.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-400">
                                            Belum ada soal. Silakan input soal baru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>