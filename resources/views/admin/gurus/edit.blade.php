<x-app-layout>
    {{-- Background Wrapper (Light Gray) --}}
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">

        {{-- Dekorasi Latar Belakang (Sangat Halus) --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-[80px] opacity-50"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-indigo-100 rounded-full mix-blend-multiply filter blur-[80px] opacity-50"></div>
        </div>

        {{-- Konten Utama --}}
        <div class="max-w-3xl mx-auto relative z-10">

            {{-- Header & Tombol Kembali --}}
            <div class="flex justify-between items-center mb-8 animate-fade-in-down">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Edit Data Guru</h2>
                    <p class="mt-1 text-gray-500 text-sm">Perbarui informasi profil dan kredensial pengajar.</p>
                </div>
                <a href="{{ route('gurus.index') }}" class="group inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:text-blue-600 hover:border-blue-200 shadow-sm hover:shadow-md transition-all">
                    <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden relative animate-fade-in-up">

                {{-- Aksen Garis Atas (Warna Kuning/Orange untuk Edit agar beda dikit dari Create) --}}
                <div class="h-1.5 w-full bg-gradient-to-r from-indigo-500 to-purple-600"></div>

                <div class="p-8 md:p-10">
                    <form action="{{ route('gurus.update', $guru->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">

                            {{-- Input Nama --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name', $guru->name) }}" required
                                           class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-gray-400">
                                </div>
                            </div>

                            {{-- Input Email --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email', $guru->email) }}" required
                                           class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-gray-400">
                                </div>
                            </div>

                            {{-- Input Password --}}
                            <div class="pt-4 border-t border-gray-100">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru <span class="text-xs font-normal text-gray-500 ml-1">(Opsional)</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <input type="password" name="password"
                                           class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-gray-400"
                                           placeholder="Kosongkan jika tidak ingin mengganti password">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Biarkan kosong jika password tidak diubah.</p>
                            </div>

                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                            <a href="{{ route('gurus.index') }}" class="px-5 py-3 text-sm font-medium text-gray-600 hover:text-gray-800 transition">Batal</a>

                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transform transition hover:-translate-y-0.5 focus:ring-4 focus:ring-indigo-500/30">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Update Data Guru
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Info Box Bawah --}}
                <div class="bg-indigo-50/50 p-4 border-t border-indigo-100 flex items-start gap-3">
                    <svg class="w-5 h-5 text-indigo-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-xs text-indigo-800 leading-relaxed">
                        Mengubah email akan mengubah kredensial login guru tersebut. Pastikan email yang dimasukkan aktif dan benar.
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- Animasi --}}
    <style>
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down { animation: fadeInDown 0.5s ease-out forwards; }
        .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
    </style>
</x-app-layout>
