<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function index()
    {
        // Draft pasien (tabel atas)
        $pasienDraft = DB::table('t_pasien')
            ->where('status_kunjungan', 'draft')
            ->orderBy('created_at', 'desc')
            ->get();

        // Pasien antrian / pemeriksaan / selesai (tabel bawah)
        $pasienAntrian = DB::table('t_pasien')
            ->whereIn('status_kunjungan', ['antrian', 'pemeriksaan', 'ambil obat', 'selesai'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('Pasien.pasien', compact('pasienDraft', 'pasienAntrian'));
    }
    // ======================
    // CREATE FORM
    // ======================
    public function create()
    {
        $kode = $this->generateKodePasien();

        return view('Pasien.create', compact('kode'));
    }


    // ======================
    // EDIT FORM (pakai kode_pasien)
    // ======================
    public function edit($kode_pasien)
    {
        $Pasien = DB::table('t_pasien')
            ->where('kode_pasien', $kode_pasien)
            ->first();

        return view('Pasien.create', compact('Pasien'));
    }

    // ======================
    // STORE
    // ======================
    public function store(Request $request)
    {
        $request->validate([
            'kode_pasien' => 'required|unique:t_pasien,kode_pasien',
            'nama'        => 'required',
            'umur'        => 'required|numeric',
            'alamat'      => 'required',
            'kelurahan'   => 'required',
            'kecamatan'   => 'required',
            'provinsi'    => 'required',
            'kode_pos'    => 'required',
        ]);

        DB::table('t_pasien')->insert([
            'kode_pasien'      => $request->kode_pasien,
            'nama'             => $request->nama,
            'umur'             => $request->umur,
            'alamat'           => $request->alamat,
            'kelurahan'        => $request->kelurahan,
            'kecamatan'        => $request->kecamatan,
            'provinsi'         => $request->provinsi,
            'kode_pos'         => $request->kode_pos,
            'status_kunjungan' => 'draft',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        return redirect()->route('Pasien.pasien')
            ->with('success', 'Pasien berhasil ditambahkan');
    }

    // ======================
    // UPDATE (tanpa ubah kode)
    // ======================
    public function update(Request $request, $kode_pasien)
    {
        $request->validate([
            'nama'   => 'required',
            'umur'   => 'required|numeric',
            'alamat' => 'required',
            'kelurahan'   => 'required',
            'kecamatan'   => 'required',
            'provinsi'    => 'required',
            'kode_pos'    => 'required',
        ]);

        DB::table('t_pasien')
            ->where('kode_pasien', $kode_pasien)
            ->update([
                'nama'       => $request->nama,
                'umur'       => $request->umur,
                'alamat'     => $request->alamat,
                'kelurahan'  => $request->kelurahan,
                'kecamatan'  => $request->kecamatan,
                'provinsi'   => $request->provinsi,
                'kode_pos'   => $request->kode_pos,
                'updated_at' => now(),
            ]);

        return redirect()->route('Pasien.pasien')
            ->with('success', 'Pasien berhasil diperbarui');
    }

    // ======================
    // STATUS FLOW
    // ======================
    public function toAntrian($kode_pasien)
    {
        $this->updateStatus($kode_pasien, 'antrian', 'Pasien masuk antrian');
    }

    public function toPemeriksaan($kode_pasien)
    {
        $this->updateStatus($kode_pasien, 'pemeriksaan', 'Pasien dalam pemeriksaan');
    }

    public function toFarmasi($kode_pasien)
    {
        $this->updateStatus($kode_pasien, 'ambil_obat', 'Pasien ke farmasi');
    }

    public function selesai($kode_pasien)
    {
        $this->updateStatus($kode_pasien, 'selesai', 'Pelayanan pasien selesai');
    }

    private function updateStatus($kode_pasien, $status, $msg)
    {
        DB::table('t_pasien')
            ->where('kode_pasien', $kode_pasien)
            ->update([
                'status_kunjungan' => $status,
                'updated_at'       => now(),
            ]);

        return back()->with('success', $msg);
    }

    public function destroy($kode_pasien)
    {
        DB::table('t_pasien')
            ->where('kode_pasien', $kode_pasien)
            ->delete();

        return redirect()->route('Pasien.pasien')
            ->with('success', 'Pasien berhasil dihapus');
    }

    public function masukAntrian($kode_pasien)
    {
        DB::transaction(function () use ($kode_pasien) {

            $pasien = DB::table('t_pasien')
                ->where('kode_pasien', $kode_pasien)
                ->first();

            if (!$pasien) {
                abort(404);
            }

            // insert ke t_antrian + status
            DB::table('t_antrian')->insert([
                'kode_pasien'      => $pasien->kode_pasien,
                'nama'             => $pasien->nama,
                'umur'             => $pasien->umur,
                'alamat'           => $pasien->alamat,
                'status_kunjungan' => 'antrian',
                'waktu_masuk'      => now(),
                'created_at'       => now(),
            ]);

            // update status di t_pasien
            DB::table('t_pasien')
                ->where('kode_pasien', $kode_pasien)
                ->update([
                    'status_kunjungan' => 'antrian',
                    'updated_at' => now(),
                ]);
        });

        return back()->with('success', 'Pasien berhasil masuk antrian');
    }

    private function generateKodePasien()
    {
        $lastPasien = DB::table('t_pasien')
            ->select('kode_pasien');

        $lastRiwayat = DB::table('t_riwayat')
            ->select('kode_pasien');

        $last = $lastPasien
            ->union($lastRiwayat)
            ->orderBy('kode_pasien', 'desc')
            ->first();

        if (!$last) {
            return 'PS0001';
        }

        $num = (int) substr($last->kode_pasien, 2);
        $next = $num + 1;

        return 'PS' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}
