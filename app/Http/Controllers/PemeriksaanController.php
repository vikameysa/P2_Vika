<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PemeriksaanController extends Controller
{
    public function storePemeriksaan(Request $request)
    {
        $request->validate([
            'kode_pasien'   => 'required|exists:t_pasien,kode_pasien',
            'tinggi_badan'  => 'required|numeric',
            'berat_badan'   => 'required|numeric',
            'suhu_badan'    => 'required|numeric',
            'tensi'         => 'required|string',
            'keluhan'       => 'nullable|string',
            'catatan_obat'  => 'nullable|string',
        ]);

        $aksi = $request->aksi;

        if ($aksi === 'simpan') {

            DB::table('t_pemeriksaan')->insert([
                'kode_pasien'   => $request->kode_pasien,
                'tinggi_badan'  => $request->tinggi_badan,
                'berat_badan'   => $request->berat_badan,
                'suhu_badan'    => $request->suhu_badan,
                'tensi'         => $request->tensi,
                'keluhan'       => $request->keluhan,
                'catatan_obat'  => $request->catatan_obat,
                'status_kunjungan' => 'ambil obat',
                'created_at'    => now(),
            ]);

            return redirect()->back()->with('success', 'Data disimpan & lanjut ambil obat');
        }

        if ($aksi === 'akhiri') {

            // Hanya hapus dari antrian
            DB::table('t_antrian')
                ->where('kode_pasien', $request->kode_pasien)
                ->delete();

            return redirect()->route('Antrian.antrian')
                ->with('success', 'Pasien selesai & keluar dari antrian');
        }
    }
}
