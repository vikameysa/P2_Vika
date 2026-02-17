@extends('layouts.app')

@section('content')


<form
    action="{{ isset($Pasien)
        ? route('Pasien.update', $Pasien->kode_pasien)
        : route('Pasien.store') }}"
    method="POST">

    @csrf
    @if(isset($Pasien))
    @method('PUT')
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="mb-4">
                {{ isset($Pasien) ? 'Edit Data Pasien' : 'Tambah Data Pasien' }}
            </h5>

            {{-- KODE PASIEN --}}
            <div class="mb-3">
                <label class="form-label">Kode Pasien</label>

                <input type="text"
                    class="form-control"
                    value="{{ old('kode_pasien', $Pasien->kode_pasien ?? $kode ?? '') }}"
                    readonly>

                <input type="hidden"
                    name="kode_pasien"
                    value="{{ old('kode_pasien', $Pasien->kode_pasien ?? $kode ?? '') }}">
            </div>

            {{-- NAMA --}}
            <div class="mb-3">
                <label class="form-label">Nama Pasien</label>
                <input type="text"
                    name="nama"
                    class="form-control"
                    value="{{ old('nama', $Pasien->nama ?? '') }}"
                    required>
            </div>

            {{-- UMUR --}}
            <div class="mb-3">
                <label class="form-label">Umur</label>
                <input type="number"
                    name="umur"
                    class="form-control"
                    value="{{ old('umur', $Pasien->umur ?? '') }}"
                    required>
            </div>

            {{-- ALAMAT --}}
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat"
                    class="form-control"
                    rows="2"
                    required>{{ old('alamat', $Pasien->alamat ?? '') }}</textarea>
            </div>

            {{-- WILAYAH --}}
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kelurahan</label>
                    <input type="text"
                        name="kelurahan"
                        class="form-control"
                        value="{{ old('kelurahan', $Pasien->kelurahan ?? '') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Kecamatan</label>
                    <input type="text"
                        name="kecamatan"
                        class="form-control"
                        value="{{ old('kecamatan', $Pasien->kecamatan ?? '') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Provinsi</label>
                    <input type="text"
                        name="provinsi"
                        class="form-control"
                        value="{{ old('provinsi', $Pasien->provinsi ?? '') }}">
                </div>
            </div>

            {{-- KODE POS --}}
            <div class="mb-3">
                <label class="form-label">Kode Pos</label>
                <input type="text"
                    name="kode_pos"
                    class="form-control"
                    value="{{ old('kode_pos', $Pasien->kode_pos ?? '') }}">
            </div>

            {{-- STATUS --}}
            <div class="mb-3">
                <label class="form-label">Status Kunjungan</label>
                <select name="status_kunjungan" class="form-control" required>
                    @php
                    $statusList = ['draft','antrian','pemeriksaan','farmasi','selesai'];
                    $current = old('status_kunjungan', $Pasien->status_kunjungan ?? 'draft');
                    @endphp

                    @foreach($statusList as $status)
                    <option value="{{ $status }}" {{ $current == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            <a href="{{ route('Pasien.pasien') }}" class="btn btn-secondary mt-3 ms-2">
                Kembali
            </a>

        </div>
    </div>
</form>

@endsection