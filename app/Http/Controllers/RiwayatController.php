<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = DB::table('t_riwayat')
            ->orderBy('kode_pasien', 'asc')
            ->get();


        return view('Riwayat.riwayat', compact('riwayat'));
    }

    public function detail($id)
    {
        // Ambil riwayat
        $riwayat = DB::table('t_riwayat')
            ->where('id', $id)
            ->first();

        if (!$riwayat) {
            return response()->json(['error' => 'Data tidak ditemukan']);
        }

        // Data pasien
        $pasien = DB::table('t_pasien')
            ->where('kode_pasien', $riwayat->kode_pasien)
            ->first();

        // Data pemeriksaan terakhir (sesuai pasien)
        $pemeriksaan = DB::table('t_pemeriksaan')
            ->where('kode_pasien', $riwayat->kode_pasien)
            ->orderBy('created_at', 'desc')
            ->first();

        // Detail obat
        $detail = DB::table('t_detail as d')
            ->join('t_obat as o', 'd.id_obat', '=', 'o.id')
            ->where('d.id_riwayat', $id)
            ->select('o.nama_obat', 'd.jumlah')
            ->get();

        return response()->json([
            'pasien' => $pasien,
            'pemeriksaan' => $pemeriksaan,
            'detail_obat' => $detail,
        ]);
    }

    public function print($id)
{
    $riwayat = DB::table('t_riwayat')->where('id', $id)->first();

    $pasien = DB::table('t_pasien')
        ->where('kode_pasien', $riwayat->kode_pasien)
        ->first();

    $pemeriksaan = DB::table('t_pemeriksaan')
        ->where('kode_pasien', $riwayat->kode_pasien)
        ->latest()
        ->first();

    $detail = DB::table('t_detail as d')
        ->join('t_obat as o', 'd.id_obat', '=', 'o.id')
        ->where('d.id_riwayat', $id)
        ->select('o.nama_obat', 'd.jumlah')
        ->get();

    $dokter = Auth::user(); // 🔥 ambil user login

    return view('Riwayat.print', compact(
        'riwayat',
        'pasien',
        'pemeriksaan',
        'detail',
        'dokter'
    ));
}
}
