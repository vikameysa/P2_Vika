@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-body">
        <h4>Tambah rumah</h4>

        <form action="{{ route('Rumah.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $rumah['id'] ?? '' }}">

            <div class="mb-3">
                <label for="nama_rumah">Nama rumah</label>
                <input type="text" name="nama_rumah" class="form-control"
                    value="{{ $rumah['nama_rumah'] ?? '' }}" required>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ $rumah['id'] ? 'Update' : 'Simpan' }}
            </button>
        </form>

    </div>
</div>
@endsection