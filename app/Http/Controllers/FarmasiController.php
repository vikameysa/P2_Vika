<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FarmasiController extends Controller
{

    public function index()
    {
        $Farmasi = DB::table('users')
            ->where('role', 'Farmasi')
            ->get();

        return view('Farmasi.farmasi', compact('Farmasi'));
    }

    public function create()
    {
        return view('Farmasi.create');
    }

    public function edit($id)
    {
        $Farmasi = DB::table('users')->where('id', $id)->first();
        return view('Farmasi.create', compact('Farmasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'status'   => 'required|in:aktif,nonaktif',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('Farmasi', 'public');
        }

        DB::table('users')->insert([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'Farmasi',
            'status'     => $request->status,
            'avatar'     => $avatarPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('Farmasi.farmasi')
            ->with('success', 'Farmasi berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => "required|email|unique:users,email,$id",
            'status'   => 'required|in:aktif,nonaktif',
            'password' => 'nullable|min:6',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'status'     => $request->status,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('Farmasi', 'public');
        }

        DB::table('users')->where('id', $id)->update($data);

        return redirect()->route('Farmasi.farmasi')
            ->with('success', 'Farmasi berhasil diperbarui');
    }

    // ======================
    // DELETE
    // ======================
    public function destroy($id)
    {
        $Farmasi = DB::table('users')->where('id', $id)->first();

        if ($Farmasi && $Farmasi->avatar && file_exists(public_path('storage/' . $Farmasi->avatar))) {
            unlink(public_path('storage/' . $Farmasi->avatar));
        }

        DB::table('users')->where('id', $id)->delete();

        return redirect()->route('Farmasi.farmasi')
            ->with('success', 'Farmasi berhasil dihapus');
    }
}
