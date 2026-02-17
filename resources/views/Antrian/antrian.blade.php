@extends('layouts.app')

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Data Antrian Pasien</h4>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pasien</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Alamat</th>
                                <th>Waktu Masuk</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($Antrian as $a)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $a->kode_pasien }}</td>
                                <td>{{ $a->nama }}</td>
                                <td>{{ $a->umur }}</td>
                                <td>{{ $a->alamat }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->waktu_masuk)->format('d-m-Y H:i') }}</td>

                                {{-- STATUS --}}
                                <td>
                                    @switch($a->status_kunjungan)
                                    @case('antrian')
                                    <span class="badge bg-warning text-dark">Antrian</span>
                                    @break
                                    @case('pemeriksaan')
                                    <span class="badge bg-info">Pemeriksaan</span>
                                    @break
                                    @case('selesai')
                                    <span class="badge bg-success">Selesai</span>
                                    @break
                                    @default
                                    <span class="badge bg-warning text-dark">Antrian</span>
                                    @endswitch
                                </td>
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="d-flex gap-2">

                                        {{-- tombol lanjut ke pemeriksaan (opsional nanti) --}}
                                        <a href="{{ route('antrian.periksa', $a->id) }}"
                                            class="btn btn-primary btn-sm">
                                            Periksa
                                        </a>

                                        </form>

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Belum ada pasien dalam antrian
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