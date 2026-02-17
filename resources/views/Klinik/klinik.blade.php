@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Data Farmasi</h4>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pasien</th>
                                <th>Catatan Obat</th>
                                <th>Status Kunjungan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($farmasi as $f)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $f->kode_pasien }}</td>
                                <td>{{ $f->catatan_obat ?? '-' }}</td>

                                {{-- STATUS --}}
                                <td>
                                    @if ($f->status_kunjungan === 'ambil obat')
                                        <span class="badge bg-info">Ambil Obat</span>
                                    @elseif ($f->status_kunjungan === 'sudah ambil')
                                        <span class="badge bg-success">Sudah Ambil</span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            {{ $f->status_kunjungan ?? 'Belum Ambil' }}
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    @if ($f->status_kunjungan === 'sudah ambil')
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            Sudah Diambil
                                        </button>
                                    @else
                                        <a href="{{ route('Klinik.formklinik', $f->kode_pasien) }}"
                                           class="btn btn-primary btn-sm">
                                            Ambil Obat
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Data farmasi tidak ditemukan
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
