@extends('layouts.app')

@section('content')

@if(isset($Dokter))
<form action="{{ route('Dokter.update', $Dokter->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @else
    <form action="{{ route('Dokter.store') }}" method="POST" enctype="multipart/form-data">
        @endif
        @csrf


        <div class="card">
            <div class="card-body">
                <h5 class="mb-4">{{ isset($Dokter) ? 'Edit Dokter' : 'Tambah Dokter' }}</h5>

                <div class="mb-3">
                    <label class="form-label">Nama Dokter</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ $Dokter->name ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ $Dokter->email ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis poli</label>
                    <select name="id_poli" class="form-control" required>
                        <option value="">-- Pilih poli --</option>
                        @foreach($Poli as $j)
                        <option value="{{ $j->id }}"
                            {{ (isset($Dokter) && $Dokter->id == $j->id) ? 'selected' : '' }}>
                            {{ $j->nama_poli }}
                        </option>
                        @endforeach
                    </select>

                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="aktif" {{ old('status', $Dokter->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $Dokter->status ?? '') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="avatar" class="form-control">

                    @if(isset($Dokter) && $Dokter->avatar)
                    <img src="{{ asset('storage/'.$Dokter->avatar) }}"
                        class="mt-2 rounded"
                        style="width:80px;height:80px;object-fit:cover">
                    @endif
                </div>

                @if(!isset($Dokter))
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                @endif

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                <a href="{{ route('Dokter.dokter') }}" class="btn btn-secondary mt-3 ms-2">Kembali</a>

            </div>
        </div>
    </form>
    </div>
    @endsection