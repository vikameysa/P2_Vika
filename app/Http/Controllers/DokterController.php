<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    // ======================
    // INDEX
    // ======================
    public function index()
    {
        $Dokter = DB::table('users')
            ->join('t_poli', 'users.id_poli', '=', 't_poli.id')
            ->where('users.role', 'Dokter')
            ->select('users.*', 't_poli.nama_poli')
            ->get();

        $Poli = DB::table('t_poli')->orderBy('nama_poli')->get();

        return view('Dokter.dokter', compact('Dokter', 'Poli'));
    }

    // ======================
    // CREATE FORM
    // ======================
    public function create()
    {
        $Poli = DB::table('t_poli')->orderBy('nama_poli')->get();
        return view('Dokter.create', compact('Poli'));
    }

    // ======================
    // EDIT FORM
    // ======================
    public function edit($id)
    {
        $Dokter = DB::table('users')->where('id', $id)->first();
        $Poli = DB::table('t_poli')->orderBy('nama_poli')->get();

        return view('Dokter.create', compact('Dokter', 'Poli'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'id_poli'  => 'required|exists:t_poli,id',
            'status'   => 'required|in:aktif,nonaktif',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('Dokter', 'public');
        }

        DB::table('users')->insert([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'Dokter',
            'id_poli'    => $request->id_poli,
            'status'     => $request->status,
            'avatar'     => $avatarPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Dokter berhasil ditambahkan'
            ]);
        }

        return redirect()->route('Dokter.dokter')
            ->with('success', 'Dokter berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => "required|email|unique:users,email,$id",
            'id_poli'  => 'required|exists:t_poli,id',
            'status'   => 'required|in:aktif,nonaktif',
            'password' => 'nullable|min:6',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'id_poli'    => $request->id_poli,
            'status'     => $request->status,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('Dokter', 'public');
        }

        DB::table('users')->where('id', $id)->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Dokter berhasil diperbarui'
            ]);
        }

        return redirect()->route('Dokter.dokter')
            ->with('success', 'Dokter berhasil diperbarui');
    }

    // ======================
    // DELETE
    // ======================
    public function destroy($id)
    {
        $Dokter = DB::table('users')->where('id', $id)->first();

        if ($Dokter && $Dokter->avatar && file_exists(public_path('storage/' . $Dokter->avatar))) {
            unlink(public_path('storage/' . $Dokter->avatar));
        }

        DB::table('users')->where('id', $id)->delete();

        return redirect()->route('Dokter.dokter')
            ->with('success', 'Dokter berhasil dihapus');
    }
}
