@extends('layouts.app')

@section('content')

@if(isset($Farmasi))
<form action="{{ route('Farmasi.update', $Farmasi->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @else
    <form action="{{ route('Farmasi.store') }}" method="POST" enctype="multipart/form-data">
        @endif
        @csrf


        <div class="card">
            <div class="card-body">
                <h5 class="mb-4">{{ isset($Farmasi) ? 'Edit Farmasi' : 'Tambah Farmasi' }}</h5>

                <div class="mb-3">
                    <label class="form-label">Nama Farmasi</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ $Farmasi->name ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ $Farmasi->email ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="aktif" {{ old('status', $Farmasi->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $Farmasi->status ?? '') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="avatar" class="form-control">

                    @if(isset($Farmasi) && $Farmasi->avatar)
                    <img src="{{ asset('storage/'.$Farmasi->avatar) }}"
                        class="mt-2 rounded"
                        style="width:80px;height:80px;object-fit:cover">
                    @endif
                </div>

                @if(!isset($Farmasi))
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                @endif

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                <a href="{{ route('Farmasi.farmasi') }}" class="btn btn-secondary mt-3 ms-2">Kembali</a>

            </div>
        </div>
    </form>
    </div>
    @endsection