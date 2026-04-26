<x-app-layout>
    <div class="min-h-screen bg-gray-900 text-white flex flex-col items-center justify-center p-4">
        <h1 class="text-5xl font-black text-yellow-400 mb-2">MISSION ACCOMPLISHED!</h1>
        <p class="text-xl mb-8">Mafia "{{ $event->mafia_name }}" telah dikalahkan.</p>

        <div class="bg-white text-gray-900 rounded-3xl p-8 w-full max-w-2xl shadow-2xl">
            <h3 class="text-2xl font-bold mb-6 text-center border-b pb-4">🏅 Kontribusi Damage (Leaderboard Event)</h3>

            <div class="space-y-4">
                @foreach($leaderboard as $index => $p)
                    <div class="flex items-center justify-between p-4 rounded-xl {{ $index == 0 ? 'bg-yellow-100 border-2 border-yellow-400' : ($index == 1 ? 'bg-gray-100 border-2 border-gray-400' : 'bg-gray-50') }}">
                        <div class="flex items-center gap-4">
                            <span class="font-black text-xl text-gray-400">#{{ $index + 1 }}</span>
                            <div class="flex flex-col">
                                <span class="font-bold text-lg">{{ $p->user->name }}</span>
                                @if($index == 0) <span class="text-xs text-yellow-600 font-bold uppercase">Mendapat +25 XP</span> @endif
                                @if($index == 1) <span class="text-xs text-gray-600 font-bold uppercase">Mendapat +15 XP</span> @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block font-black text-2xl text-red-600">{{ $p->damage_dealt }}</span>
                            <span class="text-xs text-gray-500 uppercase">Damage</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('siswa.dashboard') }}" class="bg-blue-600 text-white px-6 py-3 rounded-full font-bold hover:bg-blue-700 transition">Kembali ke Markas</a>
            </div>
        </div>
    </div>
</x-app-layout>
