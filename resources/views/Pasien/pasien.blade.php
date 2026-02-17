@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">

        {{-- TABEL ATAS : Draft Pasien --}}
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Draft Pasien (Belum Antrian)</h4>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('Pasien.create') }}" class="btn btn-primary">
                        Create
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pasien</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pasienDraft as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->kode_pasien }}</td>
                                <td>{{ $s->nama }}</td>
                                <td>{{ $s->umur }}</td>
                                <td>{{ $s->alamat }}</td>
                                <td><span class="badge bg-secondary">Draft</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        {{-- Tombol Antrian --}}
                                        <form action="{{ route('Pasien.antrian', $s->kode_pasien) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                Antrian
                                            </button>
                                        </form>
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('Pasien.edit', $s->kode_pasien) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        {{-- Tombol Hapus --}}
                                        <form method="POST" action="{{ route('Pasien.destroy', $s->kode_pasien) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus pasien?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Tidak ada draft pasien
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TABEL BAWAH : Pasien Antrian / Selesai --}}
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pasien Antrian / Selesai</h4>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pasien</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pasienAntrian as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->kode_pasien }}</td>
                                <td>{{ $s->nama }}</td>
                                <td>{{ $s->umur }}</td>
                                <td>{{ $s->alamat }}</td>
                                <td>
                                    @switch($s->status_kunjungan)
                                    @case('antrian')
                                    <span class="badge bg-warning text-dark">Antrian</span>
                                    @break
                                    @case('pemeriksaan')
                                    <span class="badge bg-info">Pemeriksaan</span>
                                    @break
                                    @case('ambil obat')
                                    <span class="badge bg-warning text-dark">Ambil Obat</span>
                                    @break
                                    @case('selesai')
                                    <span class="badge bg-success">Selesai</span>
                                    @break
                                    @default
                                    <span class="badge bg-dark">Unknown</span>
                                    @endswitch
                                </td>
                                <td>
                                    {{-- Hanya tombol hapus --}}
                                    <form method="POST" action="{{ route('Pasien.destroy', $s->kode_pasien) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus pasien?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada pasien di antrian / selesai
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection