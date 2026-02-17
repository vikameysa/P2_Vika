@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-body">
        <h4>Tambah obat Pesan</h4>

        <form action="{{ route('Obat.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $obat['id'] ?? '' }}">

            <div class="mb-3">
                <label for="nama_obat">Nama obat</label>
                <input type="text" name="nama_obat" class="form-control"
                    value="{{ $obat['nama_obat'] ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label for="stok">Stok</label>
                <input type="number" name="stok" class="form-control"
                    value="{{ $obat['stok'] ?? '' }}" required>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ $obat['id'] ? 'Update' : 'Simpan' }}
            </button>
        </form>

    </div>
</div>
@endsection