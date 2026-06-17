<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Role berhasil diperbarui!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // ✅ VALIDASI
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255',
            'role'   => 'required|in:admin,coordinator,user',
            'position' => 'required|string|max:255',
        ]);

        // ✅ UPDATE TERMASUK POSISI
        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'role'   => $request->role,
            'position' => $request->position,
        ]);

        return redirect()->back()->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'position' => 'required|string|max:255',
            'role' => 'required|in:admin,coordinator,user',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'User baru berhasil ditambahkan!');
    }
}
