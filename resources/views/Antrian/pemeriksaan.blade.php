@extends('layouts.app')

@section('content')

<div class="row">

    {{-- KIRI : CART + TABEL DATA PEMERIKSAAN --}}
    <div class="col-md-8 d-flex flex-column gap-3">

        {{-- CART DATA PASIEN --}}
        <div class="card border-info">
            <div class="card-body">
                <h6 class="text-info">Data Pasien</h6>
                <hr>
                <p><b>Kode Pasien:</b> {{ $antrian->kode_pasien }}</p>
                <p><b>Nama:</b> {{ $antrian->nama }}</p>
                <p><b>Umur:</b> {{ $antrian->umur }} tahun</p>
                <p><b>Alamat:</b> {{ $antrian->alamat }}</p>
            </div>
        </div>

        {{-- TABEL DATA PEMERIKSAAN --}}
        <div class="card flex-grow-1">
            <div class="card-body" style="max-height:400px; overflow-y:auto;">
                <h6>Riwayat Pemeriksaan</h6>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tinggi</th>
                            <th>Berat</th>
                            <th>Suhu</th>
                            <th>Tensi</th>
                            <th>Keluhan</th>
                            <th>Obat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                        <tr>
                            <td>{{ date('d-m-Y H:i', strtotime($item->created_at)) }}</td>
                            <td>{{ $item->tinggi_badan }}</td>
                            <td>{{ $item->berat_badan }}</td>
                            <td>{{ $item->suhu_badan }}</td>
                            <td>{{ $item->tensi }}</td>
                            <td>{{ $item->keluhan }}</td>
                            <td>{{ $item->catatan_obat }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data pemeriksaan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- KANAN : FORM PEMERIKSAAN --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <h5>Form Pemeriksaan</h5>

                <form method="POST" action="{{ route('Pemeriksaan.store') }}"
                    class="flex-grow-1 d-flex flex-column justify-content-between">
                    @csrf

                    <input type="hidden" name="kode_pasien" value="{{ $antrian->kode_pasien }}">

                    <div class="mb-2">
                        <label>Tinggi Badan</label>
                        <input type="number" name="tinggi_badan"
                            class="form-control"
                            value="{{ $last->tinggi_badan ?? '' }}">
                    </div>

                    <div class="mb-2">
                        <label>Berat Badan</label>
                        <input type="number" name="berat_badan"
                            class="form-control"
                            value="{{ $last->berat_badan ?? '' }}">
                    </div>

                    <div class="mb-2">
                        <label>Suhu Badan</label>
                        <input type="text" name="suhu_badan"
                            class="form-control"
                            value="{{ $last->suhu_badan ?? '' }}">
                    </div>

                    <div class="mb-2">
                        <label>Tensi</label>
                        <input type="text" name="tensi"
                            class="form-control"
                            value="{{ $last->tensi ?? '' }}">

                    </div>

                    <div class="mb-2">
                        <label>Keluhan</label>
                        <textarea name="keluhan" class="form-control">
                        {{ $last->keluhan ?? '' }}
                        </textarea>
                    </div>

                    <div class="mb-2">
                        <label>Catatan Obat Dokter</label>
                        <textarea name="catatan_obat" class="form-control">
                        {{ $last->catatan_obat ?? '' }}
                        </textarea>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" name="aksi" value="simpan" class="btn btn-secondary flex-fill">
                            Simpan
                        </button>

                        <button type="submit" name="aksi" value="akhiri" class="btn btn-success flex-fill">
                            Akhiri Sesi
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
@endsection