<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ManagementAkunController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('role', 'like', "%$search%");
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        return view('management-akun.index', compact('users'));
    }

    public function create()
    {
        return view('management-akun.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,karyawan',
            'password' => 'required|min:6',
        ]);

        // Fix: Add email to authorized_emails first to satisfy foreign key constraint
        \Illuminate\Support\Facades\DB::table('authorized_emails')->insertOrIgnore(['email' => $request->email]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('management-akun.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('management-akun.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,karyawan',
            'password' => 'nullable|min:6', // Optional
        ]);

        // Fix: Add email to authorized_emails if changed
        if ($request->email !== $user->email) {
            \Illuminate\Support\Facades\DB::table('authorized_emails')->insertOrIgnore(['email' => $request->email]);
        }

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('management-akun.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('management-akun.index')->with('success', 'Pengguna berhasil dihapus!');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
