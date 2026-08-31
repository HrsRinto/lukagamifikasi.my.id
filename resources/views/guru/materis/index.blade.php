<x-app-layout>
    {{-- Hapus Slot Header Bawaan --}}

    {{-- WRAPPER UTAMA: Background Putih Bersih --}}
    <div class="min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8 relative">

        {{-- Dekorasi Latar Belakang Halus --}}
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-[10%] -right-[5%] w-[40rem] h-[40rem] bg-indigo-50/50 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute top-[20%] -left-[5%] w-[30rem] h-[30rem] bg-blue-50/50 rounded-full blur-3xl opacity-60"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-10 gap-4 border-b border-gray-100 pb-8">
                <div>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight">
                        Modul & Kuis
                    </h2>
                    <p class="text-gray-500 mt-2 text-lg">
                        Kelola materi pembelajaran dan bank soal untuk siswa.
                    </p>
                </div>

                {{-- Tombol Tambah Modul --}}
                <a href="{{ route('materis.create') }}" class="inline-flex items-center gap-2 px-8 py-3.5 font-bold text-white transition-all duration-200 bg-indigo-600 rounded-full hover:bg-indigo-700 shadow-lg shadow-indigo-200 hover:-translate-y-0.5">
                    <svg width="20" height="20" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                    </svg>
                    <span>Buat Modul Baru</span>
                </a>
            </div>

            {{-- ALERT SUKSES (Tambahan agar notifikasi muncul) --}}
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm relative z-20">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- GRID CONTENT --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach($materis as $materi)

                {{-- LOGIKA EKSTRAKSI ID YOUTUBE --}}
                @php
                    $video_id = $materi->youtube_id;
                    if (filter_var($video_id, FILTER_VALIDATE_URL)) {
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $video_id, $matches);
                        $video_id = $matches[1] ?? '';
                    }
                @endphp

                {{-- CARD ITEM --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-xl shadow-gray-200/40 hover:shadow-2xl hover:shadow-indigo-100/50 transition-all duration-300 group flex flex-col h-full overflow-hidden hover:-translate-y-1 relative">

                    {{-- 1. THUMBNAIL AREA --}}
                    <div class="relative h-52 overflow-hidden bg-gray-900">

                        {{-- =========================================== --}}
                        {{-- TOMBOL HAPUS (BARU DITAMBAHKAN DI SINI) --}}
                        {{-- =========================================== --}}
                        <div class="absolute top-3 right-3 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <form action="{{ route('materis.destroy', $materi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini beserta semua soal di dalamnya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white p-2 rounded-full shadow-lg hover:bg-red-700 hover:scale-110 transition-transform transform" title="Hapus Modul">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        {{-- =========================================== --}}

                        @if($video_id)
                            <img src="https://img.youtube.com/vi/{{ $video_id }}/hqdefault.jpg"
                                 alt="{{ $materi->title }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100"
                                 onerror="this.src='https://img.youtube.com/vi/{{ $video_id }}/mqdefault.jpg'">

                            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/80 to-transparent"></div>

                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/40 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <svg class="w-6 h-6 fill-current ml-1" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        @else
                            <div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center text-slate-400 group-hover:bg-slate-200 transition-colors">
                                <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span class="text-xs font-bold uppercase tracking-wider">No Video</span>
                            </div>
                        @endif

                        {{-- BADGE STATUS --}}
                        <div class="absolute top-4 left-4">
                            @if($materi->soals_count >= 15)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500 text-white shadow-lg shadow-emerald-500/30">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Lengkap
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-500 text-white shadow-lg shadow-amber-500/30">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Belum Lengkap
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- 2. CONTENT BODY --}}
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-900 leading-tight mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                {{ $materi->title }}
                            </h3>
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-2">
                                {{ Str::limit($materi->description, 80) ?? 'Tidak ada deskripsi materi.' }}
                            </p>
                        </div>

                        {{-- Progress Info & Action --}}
                        <div class="mt-auto pt-5 border-t border-dashed border-gray-100 w-full">

                            {{-- Info Bank Soal --}}
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kelengkapan Soal</span>
                                <span class="text-sm font-black {{ $materi->soals_count >= 15 ? 'text-emerald-500' : 'text-amber-500' }}">
                                    {{ $materi->soals_count }} <span class="text-gray-300 font-normal">/ 15</span>
                                </span>
                            </div>

                            {{-- Progress Bar --}}
                            <div class="w-full bg-gray-100 rounded-full h-2 mb-6 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-700 ease-out {{ $materi->soals_count >= 15 ? 'bg-emerald-500' : 'bg-amber-400' }}"
                                     style="width: {{ min(($materi->soals_count / 15) * 100, 100) }}%"></div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <a href="{{ route('materis.show', $materi->id) }}" class="block w-full py-3 bg-slate-50 hover:bg-indigo-600 text-slate-700 hover:text-white rounded-xl font-bold text-sm text-center transition-all duration-200 border border-transparent flex items-center justify-center gap-2">
                                <svg width="16" height="16" class="w-4 h-4 flex-shrink-0 animate-spin-hover" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.99l1.005.831a1.125 1.125 0 01.26 1.43l-1.297 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.43l1.004-.83c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.831a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.645-.869l.214-1.28z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Kelola Video & Soal</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            {{-- EMPTY STATE --}}
            @if($materis->isEmpty())
                <div class="mt-12 text-center py-20 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-sm mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Belum Ada Materi</h3>
                    <p class="text-gray-500 mt-2 max-w-md mx-auto">Mulai perjalanan mengajar Anda dengan membuat modul pembelajaran interaktif pertama.</p>
                    <a href="{{ route('materis.create') }}" class="mt-8 inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        + Buat Modul Sekarang
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
