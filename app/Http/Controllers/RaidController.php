<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RaidEvent;
use App\Models\RaidParticipant;
use App\Models\RaidSoal;
use App\Models\Soal; // <--- WAJIB ADA: Agar bisa ambil data dari Bank Kuis
use Illuminate\Support\Facades\Auth;

class RaidController extends Controller
{
    // =======================
    // BAGIAN GURU (ADMIN)
    // =======================

    // 1. Dashboard Utama Guru
    public function indexGuru() {
        try {
            // Gunakan caching atau limit untuk performa jika data besar
            $event = RaidEvent::first(); 

            // AUTO-CREATE: Jika belum ada event sama sekali
            if (!$event) {
                $event = RaidEvent::create([
                    'mafia_name' => 'Don Corleone',
                    'total_hp' => 100,
                    'current_hp' => 100,
                    'status' => 'closed'
                ]);
            }

            // OPTIMASI: Ambil 50 soal terbaru saja (jangan semua) dan gunakan eager loading
            $bankSoalKuis = Soal::with('materi')->latest()->limit(50)->get();
            $existingQuestions = $event->soals->pluck('pertanyaan')->toArray();

            return view('guru.raid.index', compact('event', 'bankSoalKuis', 'existingQuestions'));
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika tabel missing, lempar ke halaman error terstruktur
            return response()->view('errors.database', [
                'message' => 'Sistem mendeteksi ada tabel yang belum siap. Hal ini umum terjadi pada deployment baru.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    // 2. Update Status Event (Buka/Tutup/Mulai)
    public function updateStatus(Request $request) {
        $event = RaidEvent::first();
        if ($request->status === 'finished') {
            $this->finishRaid($event);
        } else {
            $event->update(['status' => $request->status]);
        }
        return back()->with('success', 'Status Event Diubah!');
    }

    // 3. Simpan Soal Baru (Input Manual)
    public function storeSoal(Request $request) {
        $request->validate([
            'pertanyaan' => 'required',
            'kunci_jawaban' => 'required|in:a,b,c,d',
        ]);

        $event = RaidEvent::first();

        RaidSoal::create([
            'raid_event_id' => $event->id,
            'pertanyaan' => $request->pertanyaan,
            'opsi_a' => $request->opsi_a,
            'opsi_b' => $request->opsi_b,
            'opsi_c' => $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'kunci_jawaban' => $request->kunci_jawaban
        ]);

        return back()->with('success', 'Soal berhasil ditambahkan ke Bank Soal Mafia!');
    }

    // 4. IMPORT SOAL (Fitur Baru)
    public function importSoal($id) {
        $sumber = Soal::find($id); // Ambil soal asli dari tabel Kuis
        $event = RaidEvent::first();

        if ($sumber) {
            // Salin data ke tabel Raid
            RaidSoal::create([
                'raid_event_id' => $event->id,
                'pertanyaan' => $sumber->question, // Sesuaikan dengan nama kolom tabel 'soals'
                'opsi_a' => $sumber->option_a,
                'opsi_b' => $sumber->option_b,
                'opsi_c' => $sumber->option_c,
                'opsi_d' => $sumber->option_d,
                'kunci_jawaban' => strtolower($sumber->correct_answer) // Ubah 'A' jadi 'a'
            ]);
            return back()->with('success', 'Soal berhasil di-import dari Bank Kuis!');
        }

        return back()->with('error', 'Gagal mengambil soal.');
    }

    // 5. Hapus Soal Raid
    public function destroySoal($id) {
        RaidSoal::destroy($id);
        return back()->with('success', 'Soal dihapus.');
    }

    // 6. Reset Event
    public function resetEvent() {
        $event = RaidEvent::first();

        $event->update([
            'current_hp' => $event->total_hp,
            'status' => 'closed'
        ]);

        RaidParticipant::where('raid_event_id', $event->id)->delete();

        return back()->with('success', 'Event berhasil di-reset! Siap untuk sesi baru.');
    }

    // 7. Halaman Monitor Guru (Live Spectator)
    public function monitor() {
        $event = RaidEvent::first();
        return view('guru.raid.monitor', compact('event'));
    }

    // 8. API Data Monitor
    public function getMonitorData() {
        $event = RaidEvent::first();
        if (!$event) return response()->json(['status' => 'closed', 'participants' => []]);

        $participants = RaidParticipant::where('raid_event_id', $event->id)
                        ->with(['user:id,name,profile_photo_path,profile_photo_url']) // Tambahkan profile_photo_url
                        ->orderBy('damage_dealt', 'desc')
                        ->get();

        // Gunakan accessor photo_url dari model User
        $participants->transform(function($p) {
            $p->user->photo_url = $p->user->photo_url;
            return $p;
        });

        return response()->json([
            'current_hp' => $event->current_hp,
            'total_hp' => $event->total_hp,
            'status' => $event->status,
            'participants' => $participants
        ]);
    }

    // =======================
    // BAGIAN SISWA
    // =======================

    // 1. Halaman Utama Siswa
    public function indexSiswa() {
        $event = RaidEvent::first();
        $user = Auth::user();

        if (!$event || $event->status == 'closed') {
            return view('siswa.raid.closed');
        }

        $participant = RaidParticipant::where('raid_event_id', $event->id)
                        ->where('user_id', $user->id)->first();

        if ($event->status == 'finished') {
            $leaderboard = \App\Models\User::where('role', 'siswa')
                                ->orderBy('points', 'desc')
                                ->get();

            foreach ($leaderboard as $u) {
                $part = RaidParticipant::where('raid_event_id', $event->id)
                                        ->where('user_id', $u->id)
                                        ->first();
                $u->event_damage = $part ? $part->damage_dealt : 0;
                $u->event_total_points = $u->event_damage;
            }

            // Urutkan berdasarkan damage terbanyak ke terendah
            $leaderboard = $leaderboard->sortByDesc('event_damage')->values();

            return view('siswa.raid.result', compact('event', 'leaderboard', 'participant'));
        }

        if ($event->status == 'lobby') {
            if (!$participant) {
                RaidParticipant::create([
                    'raid_event_id' => $event->id,
                    'user_id' => $user->id
                ]);
            }
            return view('siswa.raid.lobby', compact('event'));
        }

        if ($event->status == 'live') {
            return view('siswa.raid.arena', compact('event'));
        }
    }

    // 2. API Data Lobby Siswa
    public function getLobbyData() {
        $event = RaidEvent::first();
        if (!$event) return response()->json(['status' => 'closed', 'players' => []]);

        $players = RaidParticipant::where('raid_event_id', $event->id)
                    ->with(['user:id,name,profile_photo_path,profile_photo_url'])
                    ->get();

        $players->transform(function($player) {
            $player->user->photo_url = $player->user->photo_url;
            return $player;
        });

        return response()->json([
            'status' => $event->status,
            'current_hp' => $event->current_hp,
            'total_hp' => $event->total_hp,
            'players' => $players
        ]);
    }

    // 3. API Ambil Soal
    public function getSoal() {
        $event = RaidEvent::first();

        if($event->current_hp <= 0) {
            return response()->json(['status' => 'finished']);
        }

        $soal = RaidSoal::where('raid_event_id', $event->id)
                ->inRandomOrder()
                ->first();

        return response()->json(['status' => 'live', 'soal' => $soal]);
    }

    // 4. API Serang Boss
    public function attackBoss(Request $request) {
        $user = Auth::user();
        $event = RaidEvent::first();
        $soal = RaidSoal::find($request->soal_id);

        $isCorrect = (strtolower($request->jawaban) == strtolower($soal->kunci_jawaban));

        if ($isCorrect && $event->current_hp > 0) {
            $event->decrement('current_hp', 1);

            RaidParticipant::where('raid_event_id', $event->id)
                ->where('user_id', $user->id)
                ->increment('damage_dealt', 1);

            if ($event->current_hp <= 0) {
                $this->finishRaid($event);
                return response()->json(['result' => 'kill', 'hp' => 0]);
            }

            return response()->json(['result' => 'hit', 'hp' => $event->current_hp]);
        }

        return response()->json(['result' => 'miss', 'hp' => $event->current_hp]);
    }

    // Fungsi Internal: Selesaikan Raid
    private function finishRaid($event) {
        if ($event->status === 'finished') {
            return;
        }
        $event->update(['status' => 'finished']);

        // Tambahkan seluruh damage_dealt dari masing-masing peserta langsung ke points user mereka
        $participants = RaidParticipant::where('raid_event_id', $event->id)->get();
        foreach ($participants as $p) {
            if ($p->damage_dealt > 0) {
                $p->user->increment('points', $p->damage_dealt);
            }
        }
    }

    // Update HP Boss (Custom Difficulty)
    public function updateBossHP(Request $request) {
        $request->validate([
            'hp_boss' => 'required|numeric|min:10|max:1000' // Batasan HP (Min 10, Max 1000)
        ]);

        $event = RaidEvent::first();

        // Update Total HP dan Reset Current HP ke Penuh
        $event->update([
            'total_hp' => $request->hp_boss,
            'current_hp' => $request->hp_boss
        ]);

        return back()->with('success', 'HP Boss berhasil diperbarui menjadi ' . $request->hp_boss . '!');
    }

    public function updateTimer(Request $request) {
        $request->validate([
            'timer_seconds' => 'required|numeric|min:10|max:300'
        ]);

        $event = RaidEvent::first();
        $event->update(['timer_seconds' => $request->timer_seconds]);

        return back()->with('success', 'Timer berhasil diubah menjadi ' . $request->timer_seconds . ' detik!');
    }

    // 9. API Ambil HP Boss Saja (Untuk Polling Cepat di Arena)
    public function getBossHP() {
        $event = RaidEvent::first();
        if (!$event) return response()->json(['hp' => 0, 'total' => 0, 'status' => 'closed']);

        return response()->json([
            'hp' => $event->current_hp,
            'total' => $event->total_hp,
            'status' => $event->status
        ]);
    }

}
