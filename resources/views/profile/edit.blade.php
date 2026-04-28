<x-app-layout>
    {{-- Header Background --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-800 pb-32 pt-12 px-4 relative overflow-hidden">
        {{-- Dekorasi Latar Belakang --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute top-10 left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-10 right-10 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <h2 class="font-bold text-3xl text-white tracking-tight">
                Pengaturan Profil
            </h2>
            <p class="text-blue-100 mt-2 text-lg">Kelola informasi akun, keamanan, dan avatar gamifikasi Anda.</p>
        </div>
    </div>

    <div class="py-12 -mt-24 px-4 sm:px-6 lg:px-8"> 
        <div class="max-w-7xl mx-auto">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- BAGIAN KIRI: KARTU PROFIL GAMIFIKASI --}}
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white shadow-2xl rounded-[30px] overflow-hidden text-center relative border border-white/20 group-hover:shadow-blue-500/50 transition-all">
                        
                        {{-- 1. BANNER DENGAN MASKOT (PENGGANTI BANNER POLOS) --}}
                        <div class="h-48 bg-gradient-to-br from-blue-500 to-indigo-600 relative overflow-hidden">
                            
                            {{-- Pattern Background Halus --}}
                            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                            
                            {{-- Label Dekoratif --}}
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/20 backdrop-blur-md text-white border border-white/30 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                                    Student Profile
                                </span>
                            </div>

                            {{-- GAMBAR MASKOT (Posisi di Kanan) --}}
                            <img src="{{ asset('img/maskot.png') }}" 
                                 class="absolute -bottom-6 -right-2 w-48 h-auto object-contain drop-shadow-2xl transform rotate-[-5deg] transition-transform duration-500 hover:scale-110 hover:rotate-0"
                                 alt="Maskot Profil">
                        </div>
                        
                        <div class="px-6 pb-8">
                            {{-- Form Upload Foto --}}
                            <form method="post" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="relative -mt-20 mb-4">
                                @csrf

                                {{-- Container Foto + Badge --}}
                                <div class="relative inline-block group text-left mr-auto"> {{-- mr-auto agar foto agak ke kiri (opsional) atau center --}}
                                    
                                    {{-- FOTO PROFIL --}}
                                    <div class="relative p-1.5 bg-white rounded-full shadow-xl overflow-hidden">
                                        @php
                                            $currentPhoto = Auth::user()->profile_photo_url 
                                                ?? (Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : null);
                                            $defaultPhoto = 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=fbbf24&color=ffffff';
                                        @endphp
                                        <img id="photoPreview" 
                                             src="{{ $currentPhoto ?? $defaultPhoto }}" 
                                             alt="Profile Photo" 
                                             class="h-32 w-32 rounded-full border-4 border-yellow-400 object-cover bg-white">
                                        
                                         {{-- Overlay Edit --}}
                                         <label for="photoInput" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full cursor-pointer opacity-0 group-hover:opacity-100 transition-all duration-300 z-10 backdrop-blur-[2px]">
                                             <div class="text-center">
                                                 <svg class="w-8 h-8 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                 </svg>
                                                 <span class="text-[10px] text-white font-bold uppercase">Ganti File</span>
                                             </div>
                                         </label>
                                     </div>

                                     {{-- BADGE RANK (Siswa Only) --}}
                                     @if(Auth::user()->role === 'siswa')
                                     <div class="absolute bottom-1 right-1 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center p-1.5 z-20 border border-gray-100" title="{{ Auth::user()->rank_label ?? 'Rank' }}">
                                         <img src="{{ Auth::user()->badge_image ?? asset('img/bronze.png') }}" alt="Rank" class="w-full h-full object-contain">
                                     </div>
                                     @endif
                                 </div>

                                 <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*" onchange="previewImage(this)">

                                 {{-- Identitas User --}}
                                 <div class="mt-4">
                                     <h3 class="text-2xl font-bold text-gray-800 leading-tight">{{ Auth::user()->name }}</h3>
                                     <div class="inline-flex items-center gap-2 mt-1">
                                         <span class="px-3 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-wider border border-blue-100">
                                             {{ Auth::user()->role }}
                                         </span>
                                     </div>
                                 </div>

                                 {{-- OPSI LINK URL (Untuk Vercel Permanen) --}}
                                 <div class="mt-6 text-left">
                                     <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Atau Gunakan Link Foto (URL)</label>
                                     <div class="flex gap-2">
                                         <input type="url" name="photo_url" value="{{ Auth::user()->profile_photo_url }}" 
                                                placeholder="https://contoh.com/foto.jpg"
                                                class="flex-1 text-xs bg-slate-50 border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 h-9"
                                                oninput="previewUrl(this.value)">
                                     </div>
                                     <p class="text-[9px] text-slate-400 mt-1 italic">*Gunakan ini agar foto tetap tampil di Vercel.</p>
                                 </div>

                                 {{-- Tombol Simpan Foto --}}
                                 <div id="savePhotoButton" class="hidden mt-4 animate-fade-in-up">
                                     <button type="submit" id="btnSubmitPhoto" class="w-full bg-slate-800 text-white px-4 py-3 rounded-xl text-sm font-bold shadow-lg hover:bg-slate-700 transition-all duration-200 flex items-center justify-center gap-2">
                                         <span id="btnText">Simpan Perubahan Foto</span>
                                         <div id="btnLoader" class="hidden w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                                     </button>
                                 </div>
                            </form>

                            {{-- Divider --}}
                            <div class="w-full h-px bg-gray-100 my-6"></div>

                            {{-- STATISTIK RANK & POIN --}}
                            @if(Auth::user()->role === 'siswa')
                                <div class="flex items-center justify-between px-2">
                                    {{-- Kolom Rank --}}
                                    <div class="text-center w-1/2 group cursor-default p-2 rounded-xl hover:bg-gray-50 transition-colors">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="flex items-center gap-1 mb-2 transition-transform group-hover:scale-110 duration-300">
                                                <img src="{{ Auth::user()->badge_image ?? asset('img/bronze.png') }}" class="w-10 h-10 drop-shadow-sm">
                                            </div>
                                            <span class="font-black text-gray-800 text-lg leading-none">{{ Auth::user()->rank_label ?? 'Bronze' }}</span>
                                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-1">Rank Saat Ini</span>
                                        </div>
                                    </div>

                                    {{-- Garis Pemisah Vertikal --}}
                                    <div class="h-12 w-px bg-gray-200"></div>

                                    {{-- Kolom Poin --}}
                                    <div class="text-center w-1/2 group cursor-default p-2 rounded-xl hover:bg-gray-50 transition-colors">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="font-black text-transparent bg-clip-text bg-gradient-to-br from-blue-600 to-indigo-600 text-4xl mb-1 leading-none transition-transform group-hover:scale-110 duration-300">
                                                {{ number_format(Auth::user()->points ?? 0) }}
                                            </div>
                                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-1">Total XP Poin</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- BAGIAN KANAN: FORM UPDATE PROFILE DLL --}}
                <div class="md:col-span-2 space-y-8">
                    
                    {{-- Form Informasi Dasar --}}
                    <div class="bg-white p-8 shadow-xl rounded-[30px] border border-white/50 relative overflow-hidden group hover:shadow-2xl transition-shadow duration-300">
                         <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                        <div class="flex items-center mb-6 border-b border-gray-100 pb-4">
                            <div class="bg-blue-100 p-2.5 rounded-xl mr-4 text-blue-600 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Informasi Dasar</h3>
                                <p class="text-sm text-gray-500">Perbarui nama tampilan dan alamat email Anda.</p>
                            </div>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- Form Password --}}
                    <div class="bg-white p-8 shadow-xl rounded-[30px] border border-white/50 relative overflow-hidden group hover:shadow-2xl transition-shadow duration-300">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-yellow-400"></div>
                        <div class="flex items-center mb-6 border-b border-gray-100 pb-4">
                            <div class="bg-yellow-100 p-2.5 rounded-xl mr-4 text-yellow-600 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Keamanan Password</h3>
                                <p class="text-sm text-gray-500">Pastikan akun Anda tetap aman dengan password yang kuat.</p>
                            </div>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Form Hapus Akun --}}
                    <div class="bg-white p-8 shadow-xl rounded-[30px] border border-white/50 relative overflow-hidden group hover:shadow-2xl transition-shadow duration-300">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-red-500"></div>
                        <div class="flex items-center mb-6 border-b border-gray-100 pb-4">
                            <div class="bg-red-100 p-2.5 rounded-xl mr-4 text-red-600 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Zona Bahaya</h3>
                                <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Script Preview Image --}}
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreview').src = e.target.result;
                    document.getElementById('savePhotoButton').classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewUrl(url) {
            if (url && url.startsWith('http')) {
                document.getElementById('photoPreview').src = url;
                document.getElementById('savePhotoButton').classList.remove('hidden');
            }
        }

        // Handle Submit Loading
        document.querySelector('form[action*="profile/photo"]').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmitPhoto');
            const text = document.getElementById('btnText');
            const loader = document.getElementById('btnLoader');
            
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
            text.innerText = 'Mengupload...';
            loader.classList.remove('hidden');
        });
    </script>
    
    {{-- Animasi Fade In --}}
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out forwards;
        }
    </style>
</x-app-layout>