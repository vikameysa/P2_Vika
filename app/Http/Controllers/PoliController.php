<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PoliController extends Controller
{
    public function poli()
    {
        $data = "Adi";
        $poli = DB::table('t_poli')->get();

        return view('Poli.poli', ['data' => $data, 'poli' => $poli]);
    }

    public function show($id)
    {
        $cek = DB::table('t_poli')->where('id', $id)->first();

        if (!$cek) {
            return redirect()->route('poli.poli')->with('error', 'Data poli tidak ditemukan.');
        }

        $poli = [
            'id' => $cek->id,
            'nama_poli' => $cek->nama_poli,
            'created_at' => $cek->created_at,
            'updated_at' => $cek->updated_at
        ];

        return view('formView', ['poli' => $poli]);
    }

    public function create(Request $request)
    {
        $poli = [
            'id' => '',
            'nama_poli' => '',
            'created_at' => '',
            'updated_at' => ''
        ];
        if ($request->input('id') != '') {
            $cek = DB::table('t_poli')->where('id', $request->input('id'))->first();
            $poli = [
                'id' => $cek->id,
                'nama_poli' => $cek->nama_poli,
                'created_at' => $cek->created_at,
                'updated_at' => $cek->updated_at
            ];
        }
        return view('poli.create', ['poli' => $poli]);
    }

    public function destroy($id)
    {
        DB::table('t_poli')->where('id', $id)->delete();
        return redirect()->route('Poli.poli');
    }

    public function store(Request $request)
    {
        $data = [
            'nama_poli' => $request->nama_poli,
            'updated_at'  => now(),
        ];

        if ($request->filled('id')) {
            DB::table('t_poli')->where('id', $request->id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('t_poli')->insert($data);
        }

        return redirect()->route('Poli.poli');
    }
}
