<x-app-layout>
    {{-- Hapus Header Default Bawaan agar bisa kita custom sendiri --}}
    
    {{-- WRAPPER UTAMA (Background Gamifikasi) --}}
    <div class="min-h-screen bg-gradient-to-br from-blue-600 to-indigo-900 py-12 px-4 relative flex items-center justify-center overflow-hidden">
        
        {{-- Dekorasi Latar Belakang (Blobs - Sama seperti dashboard) --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute top-10 -left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute bottom-10 -right-10 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        </div>

        {{-- CARD EDIT PROFIL --}}
        <div class="relative z-10 w-full max-w-2xl bg-white rounded-[30px] shadow-2xl overflow-hidden border border-white/20">
            
            {{-- Header Dekoratif Card --}}
            <div class="h-32 bg-gradient-to-r from-blue-500 to-cyan-400 relative">
                {{-- Pola Background (Opsional) --}}
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                
                {{-- Judul Halaman di atas Header --}}
                <div class="absolute bottom-0 left-0 p-8 w-full bg-gradient-to-t from-white/90 to-transparent pt-12">
                   <div class="flex items-center gap-3">
                        <div class="p-3 bg-blue-600 rounded-2xl shadow-lg text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Edit Data Siswa</h2>
                            <p class="text-sm text-gray-500 font-medium">Perbarui identitas dan keamanan akunmu.</p>
                        </div>
                   </div>
                </div>
            </div>

            {{-- FORM CONTENT --}}
            <div class="p-8 pt-4">
                <form action="{{ route('siswas.update', $siswa->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    {{-- GRID LAYOUT: Nama & Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Input Nama --}}
                        <div class="space-y-2 group">
                            <label class="block text-sm font-bold text-gray-700 ml-1 group-focus-within:text-blue-600 transition-colors">
                                Nama Lengkap
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="name" value="{{ $siswa->name }}" 
                                       class="w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all bg-gray-50 focus:bg-white shadow-sm font-medium text-gray-800" 
                                       placeholder="Nama kamu..." required>
                            </div>
                        </div>

                        {{-- Input Email --}}
                        <div class="space-y-2 group">
                            <label class="block text-sm font-bold text-gray-700 ml-1 group-focus-within:text-blue-600 transition-colors">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <input type="email" name="email" value="{{ $siswa->email }}" 
                                       class="w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all bg-gray-50 focus:bg-white shadow-sm font-medium text-gray-800" 
                                       placeholder="email@sekolah.com" required>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION POIN (Gamification Style) --}}
                    <div class="relative overflow-hidden bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl p-6 border border-orange-200 flex items-center justify-between shadow-sm group hover:shadow-md transition-shadow">
                        <div>
                            <p class="text-xs font-bold text-orange-600 uppercase tracking-widest mb-1">Total Experience (XP)</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-4xl font-black text-gray-800">{{ $siswa->points }}</p>
                                <span class="text-orange-500 font-bold">Poin</span>
                            </div>
                            <p class="text-[10px] text-gray-500 mt-2 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
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

                    {{-- Input Password --}}
                    <div class="space-y-2 pt-2 border-t border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 ml-1">
                            Password Baru <span class="text-gray-400 font-normal text-xs">(Kosongkan jika tidak ingin mengganti)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 000-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" 
                                   class="w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all bg-gray-50 focus:bg-white shadow-sm font-medium placeholder-gray-400" 
                                   placeholder="••••••••">
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="pt-4 flex items-center justify-end gap-4">
                        {{-- Tombol Batal/Kembali (Opsional UX) --}}
                        <a href="{{ url()->previous() }}" class="px-6 py-3 rounded-xl text-gray-500 font-bold hover:bg-gray-100 transition-colors text-sm">
                            Batal
                        </a>
                        
                        {{-- Tombol Simpan --}}
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-xl hover:shadow-lg hover:shadow-blue-500/30 hover:scale-[1.02] active:scale-95 transition-all duration-200 font-bold text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Animasi Kecil (Opsional) --}}
    <style>
        .animate-bounce-slow {
            animation: bounce 3s infinite;
        }
    </style>
</x-app-layout>