<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $messages = [
            'required' => 'Isi kolom :attribute',
            'email' => 'Format email tidak valid',
            'max' => 'Maksimal :max karakter',
            'min' => 'Password minimal :min karakter',
            'unique' => ':attribute sudah terdaftar',
            'confirmed' => 'Konfirmasi password tidak cocok',
            'image' => 'File harus berupa gambar',
        ];

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], $messages);

        $user->nama = $validated['nama'];
        $user->email = $validated['email'];

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            // Simpler approach for XAMPP without storage link:
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/profiles'), $filename);

            $user->photo = 'images/profiles/' . $filename;
        }

        // Handle Password Update
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
