<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Report forgot password for a student.
     */
    public function reportForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email sekolah tidak ditemukan di sistem. Silakan periksa kembali email Anda.'
            ]);
        }

        if ($user->role !== 'siswa') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya akun siswa yang dapat melaporkan lupa password melalui tombol ini.'
            ]);
        }

        $user->update(['forgot_password_reported' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim! Silakan beri tahu guru Anda untuk mereset password Anda.'
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
