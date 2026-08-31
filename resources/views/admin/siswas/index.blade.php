<x-app-layout>
    {{-- Background Wrapper (Light Theme) --}}
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">

        {{-- Dekorasi Latar Belakang (Subtle Blobs - Sangat Halus) --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-[80px] opacity-60"></div>
            <div class="absolute top-1/2 right-0 w-80 h-80 bg-purple-100 rounded-full mix-blend-multiply filter blur-[80px] opacity-60"></div>
        </div>

        {{-- Konten Utama --}}
        <div class="max-w-7xl mx-auto relative z-10">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Manajemen Siswa</h2>
                    <p class="mt-1 text-gray-500 text-sm">Kelola data siswa dan pantau aktivitas gamifikasi mereka.</p>
                </div>

                {{-- Tombol Tambah --}}
                <a href="{{ route('siswas.create') }}" class="group inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20 transition-all transform hover:-translate-y-0.5 focus:ring-4 focus:ring-blue-500/30">
                    <div class="mr-2 bg-white/20 p-1 rounded-full group-hover:rotate-90 transition-transform">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    Tambah Siswa
                </a>
            </div>

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-center p-4 bg-white border-l-4 border-emerald-500 rounded-r-xl shadow-md animate-fade-in-down">
                    <div class="bg-emerald-100 p-2 rounded-full mr-3">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-gray-400 hover:text-gray-600 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            {{-- Tabel Data --}}
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        {{-- Header Tabel --}}
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-5 font-bold text-gray-500 uppercase tracking-wider text-xs">Identitas Siswa</th>
                                <th scope="col" class="px-6 py-5 text-center font-bold text-gray-500 uppercase tracking-wider text-xs">Total Poin</th>
                                <th scope="col" class="px-6 py-5 text-center font-bold text-gray-500 uppercase tracking-wider text-xs">Rank</th>
                                <th scope="col" class="px-6 py-5 text-right font-bold text-gray-500 uppercase tracking-wider text-xs">Aksi</th>
                            </tr>
                        </thead>

                        {{-- Body Tabel --}}
                        <tbody class="divide-y divide-gray-50">
                            @forelse($siswas as $siswa)
                                <tr class="hover:bg-blue-50/40 transition-colors duration-200 group">
                                    {{-- Kolom Siswa --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-11 w-11 relative">
                                                @if($siswa->profile_photo_path)
                                                    <img class="h-11 w-11 rounded-full object-cover border-2 border-white shadow-sm group-hover:border-blue-200 transition-colors" src="{{ asset('storage/' . $siswa->profile_photo_path) }}" alt="{{ $siswa->name }}">
                                                @else
                                                    <div class="h-11 w-11 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-blue-600 font-bold border-2 border-white shadow-sm group-hover:from-blue-200 group-hover:to-indigo-200 transition-colors">
                                                        {{ strtoupper(substr($siswa->name, 0, 2)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $siswa->name }}</div>
                                                <div class="text-xs text-gray-500 font-medium">{{ $siswa->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom Poin --}}
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                            <svg class="w-3.5 h-3.5 mr-1 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            {{ number_format($siswa->points) }} Poin
                                        </span>
                                    </td>

                                    {{-- Kolom Rank --}}
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2 justify-center">
                                            <img src="{{ $siswa->badge_image ?? asset('img/bronze.png') }}" 
                                                 alt="{{ $siswa->rank_label ?? 'Bronze' }}" 
                                                 class="w-7 h-7 object-contain drop-shadow-sm">
                                            <span class="text-xs font-black text-slate-700">
                                                {{ $siswa->rank_label ?? 'Bronze' }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            {{-- Edit --}}
                                            <a href="{{ route('siswas.edit', $siswa->id) }}" class="p-2 text-indigo-500 hover:text-white hover:bg-indigo-500 rounded-lg transition-all duration-200" title="Edit Data">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('siswas.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-rose-500 hover:text-white hover:bg-rose-500 rounded-lg transition-all duration-200" title="Hapus Permanen">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-gray-100 p-4 rounded-full mb-3">
                                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </div>
                                            <p class="text-lg font-semibold text-gray-700">Belum ada data siswa</p>
                                            <p class="text-sm">Klik tombol "Tambah Siswa" untuk memulai.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (Light Mode) --}}
                @if(method_exists($siswas, 'links'))
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                        {{ $siswas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Animasi --}}
    <style>
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.4s ease-out forwards;
        }
    </style>
</x-app-layout>
