<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KlinikController extends Controller
{

    public function index()
    {
        $farmasi = DB::table('t_pemeriksaan as per')
            ->join('t_pasien as p', 'per.kode_pasien', '=', 'p.kode_pasien')
            ->where('per.status_kunjungan', 'ambil obat')
            ->select(
                'per.kode_pasien',
                'p.nama',
                'per.catatan_obat',
                'per.status_kunjungan'
            )
            ->orderBy('per.id', 'desc')
            ->get();

        return view('Klinik.klinik', compact('farmasi'));
    }



    public function simpan(Request $request, $kode_pasien)
    {
        foreach ($request->jumlah as $id_obat => $jumlah) {

            if ($jumlah > 0) {

                DB::table('t_farmasi')->insert([
                    'id_obat' => $id_obat,
                    'kode_pasien' => $kode_pasien,
                    'jumlah' => $jumlah
                ]);

                DB::table('t_obat')
                    ->where('id', $id_obat)
                    ->decrement('stok', $jumlah);
            }
        }

        return redirect()->back()->with('success', 'Obat berhasil disimpan');
    }



    /*
    |--------------------------------------------------------------------------
    | 2. UPDATE / KURANGI OBAT DI CART
    |--------------------------------------------------------------------------
    */

    public function updateSemua(Request $request, $kode_pasien)
    {
        DB::beginTransaction();

        try {

            foreach ($request->jumlah as $id => $jumlahBaru) {

                $cart = DB::table('t_farmasi')
                    ->where('id', $id)
                    ->lockForUpdate()
                    ->first();

                if (!$cart) continue;

                $jumlahLama = $cart->jumlah;

                if ($jumlahBaru > $jumlahLama) {
                    throw new \Exception('Tidak boleh menambah dari halaman ini');
                }

                // Jika jadi 0 → hapus dan kembalikan stok
                if ($jumlahBaru == 0) {

                    DB::table('t_obat')
                        ->where('id', $cart->id_obat)
                        ->increment('stok', $jumlahLama);

                    DB::table('t_farmasi')
                        ->where('id', $id)
                        ->delete();
                } else {

                    $selisih = $jumlahLama - $jumlahBaru;

                    if ($selisih > 0) {
                        DB::table('t_obat')
                            ->where('id', $cart->id_obat)
                            ->increment('stok', $selisih);
                    }

                    DB::table('t_farmasi')
                        ->where('id', $id)
                        ->update([
                            'jumlah' => $jumlahBaru
                        ]);
                }
            }

            DB::commit();

            return back()->with('success', 'Cart diperbarui');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    /*
    |--------------------------------------------------------------------------
    | 3. SELESAI → PINDAH KE RIWAYAT + DETAIL
    |--------------------------------------------------------------------------
    */

    public function selesai($kode_pasien)
    {
        DB::beginTransaction();

        try {

            // Ambil pemeriksaan terakhir
            $pemeriksaan = DB::table('t_pemeriksaan')
                ->where('kode_pasien', $kode_pasien)
                ->latest()
                ->first();

            if (!$pemeriksaan) {
                throw new \Exception('Data pemeriksaan tidak ditemukan');
            }

            // Ambil cart farmasi
            $cart = DB::table('t_farmasi')
                ->where('kode_pasien', $kode_pasien)
                ->get();

            if ($cart->count() == 0) {
                throw new \Exception('Belum ada obat yang diambil');
            }

            /*
            |--------------------------------------------------------------------------
            | INSERT KE T_RIWAYAT
            |--------------------------------------------------------------------------
            */

            $idRiwayat = DB::table('t_riwayat')->insertGetId([
                'kode_pasien'     => $kode_pasien,
                'tanggal'         => now(),
                'tinggi_badan'    => $pemeriksaan->tinggi_badan,
                'berat_badan'     => $pemeriksaan->berat_badan,
                'tensi'           => $pemeriksaan->tensi,
                'suhu_badan'      => $pemeriksaan->suhu_badan,
                'keluhan'         => $pemeriksaan->keluhan,
                'catatan_obat'    => $pemeriksaan->catatan_obat,
                'status_kunjungan' => 'selesai',
                'created_at'      => now()
            ]);


            /*
            |--------------------------------------------------------------------------
            | INSERT KE T_DETAIL (OBAT)
            |--------------------------------------------------------------------------
            */

            foreach ($cart as $item) {

                DB::table('t_detail')->insert([
                    'id_riwayat' => $idRiwayat,
                    'id_obat'    => $item->id_obat,
                    'jumlah'     => $item->jumlah,
                    'created_at' => now()
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | UPDATE STATUS PEMERIKSAAN
            |--------------------------------------------------------------------------
            */

            DB::table('t_pemeriksaan')
                ->where('kode_pasien', $kode_pasien)
                ->update([
                    'status_kunjungan' => 'selesai'
                ]);


            /*
            |--------------------------------------------------------------------------
            | HAPUS CART FARMASI
            |--------------------------------------------------------------------------
            */

            DB::table('t_farmasi')
                ->where('kode_pasien', $kode_pasien)
                ->delete();


            DB::commit();

            return redirect()
                ->route('Klinik.klinik')
                ->with('success', 'Pasien selesai & masuk riwayat');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function form($kode_pasien)
    {
        $pasien = DB::table('t_pasien')
            ->where('kode_pasien', $kode_pasien)
            ->first();

        $pemeriksaan = DB::table('t_pemeriksaan')
            ->where('kode_pasien', $kode_pasien)
            ->latest()
            ->first();

        $obat = DB::table('t_obat')->get();

        $cart = DB::table('t_farmasi as f')
            ->join('t_obat as o', 'f.id_obat', '=', 'o.id')
            ->where('f.kode_pasien', $kode_pasien)
            ->select(
                'f.id',
                'f.id_obat',
                'o.nama_obat',
                'f.jumlah'
            )
            ->get();

        return view('Klinik.formklinik', compact(
            'pasien',
            'pemeriksaan',
            'obat',
            'cart',
            'kode_pasien'
        ));
    }
}
