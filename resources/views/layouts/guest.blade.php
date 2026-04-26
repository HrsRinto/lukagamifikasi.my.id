<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gamifikasi') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-600 to-indigo-800 p-4">
            
            <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
                
                <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                    {{ $slot }}
                </div>

                <div class="w-full md:w-1/2 bg-blue-50 p-8 md:p-12 flex flex-col justify-center items-center text-center border-l border-blue-100">
                    
                    <div class="flex items-center justify-center gap-6 mb-6">
                        <div class="bg-white p-3 rounded-xl shadow-sm h-24 w-24 flex items-center justify-center">
                            <img src="{{ asset('images/logo_kampus.png') }}" 
                                 alt="Logo STIKOM" 
                                 class="max-h-full max-w-full object-contain"
                                 onerror="this.src='https://ui-avatars.com/api/?name=STIKOM&background=random&color=fff'">
                        </div>

                        <span class="text-gray-400 font-bold text-xl">X</span>

                        <div class="bg-white p-3 rounded-xl shadow-sm h-24 w-24 flex items-center justify-center">
                            <img src="{{ asset('images/logo_sekolah.png') }}" 
                                 alt="Logo Sekolah" 
                                 class="max-h-full max-w-full object-contain"
                                 onerror="this.src='https://ui-avatars.com/api/?name=Sekolah&background=random&color=fff'">
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">Sistem Gamifikasi Pembelajaran</h3>
                    <p class="text-sm text-gray-600 leading-relaxed font-medium">
                        Kolaborasi Riset & Teknologi<br>
                        <span class="text-blue-700 font-bold">STIKOM Yos Sudarso</span> 
                        <br>x<br>
                        <span class="text-indigo-700 font-bold">Sekolah Terang Mulia Purwokerto</span>
                    </p>

                    <div class="mt-8 text-xs text-gray-400">
                        &copy; {{ date('Y') }} Development Team
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>