<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }



    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        // --- LOGIKA UNTUK UPLOAD FOTO ---
        if ($request->hasFile('photo')) {
            // 1. Validasi File (Harus gambar, max 2MB)
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // 2. Simpan file ke folder "public/profile-photos"
            $path = $request->file('photo')->store('profile-photos', 'public');
            // 3. Simpan path/alamat file ke database user
            $request->user()->profile_photo_path = $path;
        }
        // -------------------------------------

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Khusus untuk update foto profil saja.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048', 
            'photo_url' => 'nullable|url',
        ]);

        $user = $request->user();

        // 1. Jika ada upload file
        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
            $user->profile_photo_url = null; // Reset URL jika upload baru
        } 
        
        // 2. Jika ada input URL
        if ($request->photo_url) {
            $user->profile_photo_url = $request->photo_url;
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
                $user->profile_photo_path = null;
            }
        }

        $user->save();

        return back()->with('status', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}


