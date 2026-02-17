<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function obat()
    {
        $data = "Adi";
        $obat = DB::table('t_obat')->get();

        return view('Obat.obat', ['data' => $data, 'obat' => $obat]);
    }

    public function show($id)
    {
        $cek = DB::table('t_obat')->where('id', $id)->first();

        if (!$cek) {
            return redirect()->route('Obat.obat')->with('error', 'Data obat tidak ditemukan.');
        }

        $obat = [
            'id' => $cek->id,
            'nama_obat' => $cek->nama_obat,
            'stok' => $cek->stok,
            'created_at' => $cek->created_at,
            'updated_at' => $cek->updated_at
        ];

        return view('formView', ['obat' => $obat]);
    }

    public function create(Request $request)
    {
        $obat = [
            'id' => '',
            'nama_obat' => '',
            'stok' => '',
            'created_at' => '',
            'updated_at' => ''
        ];
        if ($request->input('id') != '') {
            $cek = DB::table('t_obat')->where('id', $request->input('id'))->first();
            $obat = [
                'id' => $cek->id,
                'nama_obat' => $cek->nama_obat,
                'stok' => $cek->stok,
                'created_at' => $cek->created_at,
                'updated_at' => $cek->updated_at
            ];
        }
        return view('Obat.create', ['obat' => $obat]);
    }

    public function destroy($id)
    {
        DB::table('t_obat')->where('id', $id)->delete();
        return redirect()->route('Obat.obat');
    }

    public function store(Request $request)
    {
        $data = [
            'nama_obat' => $request->nama_obat,
            'stok' => $request->stok,
            'updated_at'  => now(),
        ];

        if ($request->filled('id')) {
            DB::table('t_obat')->where('id', $request->id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('t_obat')->insert($data);
        }

        return redirect()->route('Obat.obat');
    }
}
