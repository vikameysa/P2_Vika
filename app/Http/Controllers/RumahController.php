<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RumahController extends Controller
{
    public function rumah()
    {
        $data = "Adi";
        $rumah = DB::table('t_rumah')->get();

        return view('Rumah.rumah', ['data' => $data, 'rumah' => $rumah]);
    }

    public function show($id)
    {
        $cek = DB::table('t_rumah')->where('id', $id)->first();

        if (!$cek) {
            return redirect()->route('Rumah.rumah')->with('error', 'Data rumah tidak ditemukan.');
        }

        $rumah = [
            'id' => $cek->id,
            'nama_rumah' => $cek->nama_rumah,
            'created_at' => $cek->created_at,
            'updated_at' => $cek->updated_at
        ];

        return view('formView', ['rumah' => $rumah]);
    }

    public function create(Request $request)
    {
        $rumah = [
            'id' => '',
            'nama_rumah' => '',
            'created_at' => '',
            'updated_at' => ''
        ];
        if ($request->input('id') != '') {
            $cek = DB::table('t_rumah')->where('id', $request->input('id'))->first();
            $rumah = [
                'id' => $cek->id,
                'nama_rumah' => $cek->nama_rumah,
                'created_at' => $cek->created_at,
                'updated_at' => $cek->updated_at
            ];
        }
        return view('Rumah.create', ['rumah' => $rumah]);
    }

    public function destroy($id)
    {
        DB::table('t_rumah')->where('id', $id)->delete();
        return redirect()->route('Rumah.rumah');
    }

    public function store(Request $request)
    {
        $data = [
            'nama_rumah' => $request->nama_rumah,
            'updated_at'  => now(),
        ];

        if ($request->filled('id')) {
            DB::table('t_rumah')->where('id', $request->id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('t_rumah')->insert($data);
        }

        return redirect()->route('Rumah.rumah');
    }
}
