@extends('layouts.app')

@section('content')



<div class="row">

    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Ambil Obat</h5>

                <form method="POST" action="{{ route('Klinik.simpan', $kode_pasien) }}">
                    @csrf
                    <input type="hidden" name="kode_pasien" value="{{ $kode_pasien }}">


                    <div style="max-height:450px; overflow-y:auto;">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Obat</th>
                                    <th width="100">Stok</th>
                                    <th width="120">Jumlah Ambil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obat as $o)
                                <tr>
                                    <td>{{ $o->nama_obat }}</td>
                                    <td>{{ $o->stok }}</td>
                                    <td>
                                        <input type="number"
                                            name="jumlah[{{ $o->id }}]"
                                            value="0"
                                            min="0"
                                            max="{{ $o->stok }}"
                                            class="form-control"
                                            {{ $o->stok == 0 ? 'disabled' : '' }}>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-success btn-sm px-4">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">

                {{-- DATA PASIEN --}}
                <h6 class="text-primary">Data Pasien</h6>
                <hr>
                <p><b>Kode:</b> {{ $pasien->kode_pasien }}</p>
                <p><b>Nama:</b> {{ $pasien->nama }}</p>
                <p><b>Umur:</b> {{ $pasien->umur ?? '-' }} tahun</p>
                <p><b>Alamat:</b> {{ $pasien->alamat ?? '-' }}</p>

                <hr>

                {{-- DATA PEMERIKSAAN --}}
                <h6 class="text-primary">Data Pemeriksaan</h6>

                <div class="row small">
                    <div class="col-6 mb-2">
                        <b>Tinggi:</b><br>
                        {{ $pemeriksaan->tinggi_badan ?? '-' }} cm
                    </div>

                    <div class="col-6 mb-2">
                        <b>Berat:</b><br>
                        {{ $pemeriksaan->berat_badan ?? '-' }} kg
                    </div>

                    <div class="col-6 mb-2">
                        <b>Tensi:</b><br>
                        {{ $pemeriksaan->tensi ?? '-' }}
                    </div>

                    <div class="col-6 mb-2">
                        <b>Suhu:</b><br>
                        {{ $pemeriksaan->suhu_badan ?? '-' }}
                    </div>
                </div>

                <div class="mt-2 small">
                    <b>Keluhan:</b>
                    <div class="border rounded p-2 bg-light">
                        {{ $pemeriksaan->keluhan ?? '-' }}
                    </div>
                </div>

                <div class="mt-2 small">
                    <b>Catatan Obat:</b>
                    <div class="border rounded p-2 bg-light">
                        {{ $pemeriksaan->catatan_obat ?? '-' }}
                    </div>
                </div>

                <hr>

                <h6 class="text-primary">Obat Yang Sudah Diambil</h6>

                <form method="POST" action="{{ route('Klinik.updateSemua', $kode_pasien) }}">
                    @csrf
                    @method('PUT')

                    <div style="max-height:200px; overflow-y:auto;">
                        <table class="table table-bordered table-sm mt-2">
                            <thead class="table-light">
                                <tr>
                                    <th>Obat</th>
                                    <th width="100">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cart as $c)
                                <tr>
                                    <td>{{ $c->nama_obat }}</td>
                                    <td>
                                        <input type="number"
                                            name="jumlah[{{ $c->id }}]"
                                            value="{{ $c->jumlah }}"
                                            min="0"
                                            max="{{ $c->jumlah }}"
                                            class="form-control form-control-sm">
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">
                                        Belum ada obat diambil
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(count($cart) > 0)
                    <div class="mt-2 text-end">
                        <button type="submit" class="btn btn-warning btn-sm px-3">
                            Update
                        </button>
                    </div>

                    @endif
                </form>

                <hr>

                {{-- BUTTON INPUT DATA --}}
                @if(count($cart) > 0)
                <form action="{{ route('Klinik.selesai', $kode_pasien) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Selesai
                    </button>
                </form>
                @endif

            </div>
        </div>
    </div>


</div>
@endsection