<x-app-layout>

    {{-- PERBAIKAN UTAMA: x-data membungkus SAMPAI BAWAH (termasuk modal) --}}
    <div class="py-8 bg-gray-50 min-h-screen" x-data="{ 
        openCreateModal: false, 
        openEditModal: false,
        editItem: { id: '', name: '', price: '', stock: '', description: '', image: '' }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- HEADER SECTION --}}
            <div class="relative bg-gradient-to-r from-slate-800 to-slate-900 rounded-3xl p-10 text-white shadow-2xl overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-500/20 border border-yellow-500/50 text-yellow-300 text-xs font-bold mb-4">
                            <span>👑</span> Fitur Motivasi Siswa
                        </div>
                        <h1 class="text-4xl font-black mb-2 tracking-tight">Manajemen Bursa</h1>
                        <p class="text-slate-300 text-lg max-w-2xl font-light">
                            Atur reward/privilese ujian yang akan didapatkan secara otomatis oleh 4 siswa teratas di leaderboard.
                        </p>
                    </div>
                    
                    {{-- TOMBOL PEMICU MODAL --}}
                    <button @click="openCreateModal = true" type="button" class="group bg-yellow-500 text-slate-900 px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-yellow-500/50 hover:scale-105 transition-all duration-300 flex items-center gap-2 cursor-pointer">
                        <span>+ Tambah Barang Baru</span>
                    </button>
                </div>
            </div>

            {{-- ALERT NOTIFIKASI --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <div>
                        <p class="font-bold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- LIST BARANG --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($items as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col h-full group">
                        {{-- Preview Image --}}
                        <div class="h-40 overflow-hidden relative">
                            <img src="{{ filter_var($item->image, FILTER_VALIDATE_URL) ? $item->image : ($item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1593642532400-2682810df593?q=80&w=500&auto=format&fit=crop') }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/20"></div>
                        </div>

                        <div class="p-6 flex-1">
                            <div class="flex justify-between items-start mb-4">
                                <div class="bg-indigo-100 text-indigo-700 font-black px-3 py-1 rounded-lg text-xs">
                                    Peringkat ke-{{ $item->price }}
                                </div>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition">{{ $item->name }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">
                                {{ $item->description }}
                            </p>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                            <button @click="editItem = { id: '{{ $item->id }}', name: '{{ $item->name }}', price: '{{ $item->price }}', stock: '{{ $item->stock }}', description: '{{ $item->description }}', image: '{{ $item->image }}' }; openEditModal = true" 
                                    class="text-blue-600 hover:text-blue-800 text-sm font-bold">
                                Edit Barang
                            </button>
                            
                            <form action="{{ route('shop-guru.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-300">
                        <p class="text-gray-400 text-lg font-medium">Belum ada barang yang dijual.</p>
                        <p class="text-gray-300 text-sm">Klik tombol Tambah di atas untuk mulai.</p>
                    </div>
                @endforelse
            </div>

            {{-- TABEL RIWAYAT TRANSAKSI --}}
            <div class="mt-12 bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <span>📜</span> Riwayat Penukaran Siswa
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-8 py-4 font-bold">Waktu</th>
                                <th class="px-6 py-4 font-bold">Nama Siswa</th>
                                <th class="px-6 py-4 font-bold">Barang Dibeli</th>
                                <th class="px-6 py-4 font-bold text-right">Tipe Claim</th>
                                <th class="px-8 py-4 font-bold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if(isset($transactions))
                                @forelse($transactions as $trx)
                                    <tr class="hover:bg-blue-50/50 transition-colors">
                                        <td class="px-8 py-4 text-sm text-gray-500">
                                            {{ $trx->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-bold text-gray-800">{{ $trx->user?->name ?? 'Siswa Terhapus' }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-700">
                                            {{ $trx->item?->name ?? 'Barang Terhapus' }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                             <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-bold">
                                                 Leaderboard Reward
                                             </span>
                                        </td>
                                        <td class="px-8 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✅ Berhasil
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-8 py-12 text-center text-gray-400">
                                            Belum ada siswa yang melakukan pembelian.
                                        </td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- MODAL FORM TAMBAH BARANG --}}
        <div x-show="openCreateModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm" @click="openCreateModal = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Tambah Barang Baru</h3>
                    <form action="{{ route('shop-guru.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Barang</label>
                            <input type="text" name="name" required class="w-full rounded-lg border-gray-300" placeholder="Voucher Diskon">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Peringkat Sasaran (1-4)</label>
                            <input type="number" name="price" required min="1" max="4" class="w-full rounded-lg border-gray-300" placeholder="Contoh: 1 untuk Peringkat 1">
                            <input type="hidden" name="stock" value="9999">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Link Foto (Image URL)</label>
                            <input type="url" name="image_url" class="w-full rounded-lg border-gray-300" placeholder="https://image-cool.com/pic.jpg">
                            <p class="text-[10px] text-gray-400 mt-1">Kosongkan jika ingin upload file manual di bawah.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Atau Upload File</label>
                            <input type="file" name="image" class="w-full text-xs">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300"></textarea>
                        </div>
                        <div class="mt-8 flex justify-end gap-3">
                            <button type="button" @click="openCreateModal = false" class="px-4 py-2 font-bold text-gray-400">Batal</button>
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-xl shadow-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL FORM EDIT BARANG --}}
        <div x-show="openEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm" @click="openEditModal = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit Barang</h3>
                    <form :action="`{{ url('shop-guru') }}/${editItem.id}`" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Barang</label>
                            <input type="text" name="name" x-model="editItem.name" required class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Peringkat Sasaran (1-4)</label>
                            <input type="number" name="price" x-model="editItem.price" required min="1" max="4" class="w-full rounded-lg border-gray-300">
                            <input type="hidden" name="stock" value="9999">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Link Foto (Image URL)</label>
                            <input type="url" name="image_url" :value="editItem.image.startsWith('http') ? editItem.image : ''" class="w-full rounded-lg border-gray-300" placeholder="https://...">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Ganti File Gambar</label>
                            <input type="file" name="image" class="w-full text-xs">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" x-model="editItem.description" rows="3" class="w-full rounded-lg border-gray-300"></textarea>
                        </div>
                        <div class="mt-8 flex justify-end gap-3">
                            <button type="button" @click="openEditModal = false" class="px-4 py-2 font-bold text-gray-400">Batal</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-xl shadow-lg">Update Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    </div> {{-- Penutup Div Utama yang membawa x-data --}}

</x-app-layout>