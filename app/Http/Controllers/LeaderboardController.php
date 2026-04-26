<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        // 1. Ambil semua siswa
        // 2. Urutkan berdasarkan poin tertinggi (DESC)
        // 3. Jika poin sama, urutkan berdasarkan siapa yang levelnya lebih tinggi/dulu (Opsional)
        $leaderboard = User::where('role', 'siswa')
                            ->orderBy('points', 'desc')
                            ->get();

        return view('guru.leaderboard.index', compact('leaderboard'));
    }
}