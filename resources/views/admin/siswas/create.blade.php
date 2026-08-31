<x-app-layout>
    {{-- Background Decoration (Opsional, agar menyatu dengan tema dashboard) --}}
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-purple-100 rounded-full blur-3xl opacity-50"></div>
    </div>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Header & Back Button --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-gray-800 tracking-tight">Tambah Siswa Baru</h2>
                    <p class="text-gray-500 text-sm mt-1">Masukkan data siswa untuk mendaftarkan mereka ke sistem gamifikasi.</p>
                </div>
                <a href="{{ route('siswas.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>

            {{-- Form Card --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-[2rem] border border-gray-100 relative">

                {{-- Top Accent Bar --}}
                <div class="h-2 w-full bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>

                <div class="p-8 md:p-12">
                    <form action="{{ route('siswas.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Kolom Kiri: Ilustrasi / Info (Opsional) atau Field Nama --}}
                            <div class="col-span-1 md:col-span-2">
                                <label class="block font-bold text-sm text-gray-700 mb-2">Nama Lengkap Siswa</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <input type="text" name="name" class="w-full pl-10 border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-3 transition-all" placeholder="Contoh: Budi Santoso" required>
                                </div>
                            </div>

                            {{-- Kolom Email --}}
                            <div>
                                <label class="block font-bold text-sm text-gray-700 mb-2">Email Sekolah</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                                    </div>
                                    <input type="email" name="email" class="w-full pl-10 border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-3 transition-all" placeholder="siswa@sekolah.com" required>
                                </div>
                            </div>

                            {{-- Kolom Password --}}
                            <div>
                                <label class="block font-bold text-sm text-gray-700 mb-2">Password Awal</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    </div>
                                    <input type="password" name="password" class="w-full pl-10 border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-3 transition-all" placeholder="••••••••" required>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Actions --}}
                        <div class="flex items-center justify-end mt-10 pt-6 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg hover:shadow-xl hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Simpan Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info Card Bawah --}}
            <div class="mt-6 bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3 text-blue-700 text-sm">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>Siswa akan otomatis mendapatkan Rank <strong>Bronze</strong> dan 0 Poin saat pertama kali dibuat. Pastikan email unik dan password minimal 8 karakter.</p>
            </div>

        </div>
    </div>
</x-app-layout>
