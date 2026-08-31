<x-app-layout>
    {{-- Background Decoration (Sama seperti tambah siswa) --}}
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-purple-100 rounded-full blur-3xl opacity-50"></div>
    </div>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Header & Back Button --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-gray-800 tracking-tight">Edit Data Siswa</h2>
                    <p class="text-gray-500 text-sm mt-1">Perbarui identitas, poin, dan keamanan akun siswa.</p>
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
                    <form action="{{ route('siswas.update', $siswa->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Input Nama --}}
                            <div class="col-span-1 md:col-span-2">
                                <label class="block font-bold text-sm text-gray-700 mb-2">Nama Lengkap Siswa</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <input type="text" name="name" value="{{ $siswa->name }}" class="w-full pl-10 border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-3 transition-all font-medium text-gray-800" placeholder="Contoh: Budi Santoso" required>
                                </div>
                            </div>

                            {{-- Input Email --}}
                            <div class="col-span-1 md:col-span-2">
                                <label class="block font-bold text-sm text-gray-700 mb-2">Alamat Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                                    </div>
                                    <input type="email" name="email" value="{{ $siswa->email }}" class="w-full pl-10 border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-3 transition-all font-medium text-gray-800" placeholder="siswa@sekolah.com" required>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION POIN (Gamification Style - Modern & Tidy) --}}
                        <div class="relative overflow-hidden bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl p-6 border border-orange-100 flex items-center justify-between shadow-sm group hover:shadow-md transition-shadow">
                            <div>
                                <p class="text-xs font-bold text-orange-600 uppercase tracking-widest mb-1">Total Poin</p>
                                <div class="flex items-baseline gap-2">
                                    <p class="text-4xl font-black text-gray-800">{{ $siswa->points }}</p>
                                    <span class="text-orange-500 font-bold">Poin</span>
                                </div>
                                <p class="text-[10px] text-gray-500 mt-2 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-orange-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    Poin bertambah otomatis dari aktivitas belajar.
                                </p>
                            </div>
                            {{-- Ikon Dekorasi --}}
                            <div class="bg-white p-3 rounded-full shadow-lg border-2 border-orange-100">
                                 <img src="{{ asset('img/gold.png') }}" onerror="this.src='https://cdn-icons-png.flaticon.com/512/3112/3112946.png'" class="w-12 h-12 object-contain animate-bounce-slow">
                            </div>
                        </div>

                        {{-- Input Password Baru --}}
                        <div class="space-y-2 pt-6 border-t border-gray-100">
                            <label class="block font-bold text-sm text-gray-700">
                                Password Baru <span class="text-gray-400 font-normal text-xs">(Kosongkan jika tidak ingin mengganti)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                </div>
                                <input type="password" name="password" class="w-full pl-10 border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-3 transition-all" placeholder="••••••••">
                            </div>
                        </div>

                        {{-- Footer Actions --}}
                        <div class="flex items-center justify-end gap-4 mt-10 pt-6 border-t border-gray-100">
                            <a href="{{ route('siswas.index') }}" class="px-6 py-3 rounded-xl text-gray-500 font-bold hover:bg-gray-100 transition-colors text-sm">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg hover:shadow-xl hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- Script Animasi Kecil --}}
    <style>
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .animate-bounce-slow {
            animation: bounce 3s infinite ease-in-out;
        }
    </style>
</x-app-layout>