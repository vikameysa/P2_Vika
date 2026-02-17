@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Tabel Data Dokter</h4>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('Dokter.create') }}" class="btn btn-primary">
                        Create
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Photo</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Poli</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($Dokter as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($s->avatar)
                                    <img src="{{ asset('storage/'.$s->avatar) }}"
                                        style="width:60px;height:60px;object-fit:cover;border-radius:4px;">
                                    @else
                                    <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td>{{ $s->name }}</td>
                                <td>{{ $s->email }}</td>
                                <td>{{ $s->nama_poli }}</td>
                                <td>{{ $s->status }}</td>

                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#modalDokter{{ $s->id }}">
                                        View
                                    </button>

                                        <a href="{{ route('Dokter.edit', $s->id) }}"
                                            class="btn btn-outline-warning btn-sm">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('Dokter.destroy', $s->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Yakin hapus Dokter ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            
                           <!-- MODAL DETAIL Dokter -->
                            <div class="modal fade" id="modalDokter{{ $s->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                            <h5 class="modal-title">Detail Dokter</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                                 <div class="modal-body text-center">

                                            {{-- FOTO --}}
                                            @if($s->avatar)
                                            <img src="{{ asset('storage/'.$s->avatar) }}"
                                                class="rounded mb-3"
                                                style="width:120px;height:120px;object-fit:cover;">
                                            @else
                                            <img src="{{ asset('assets/images/no-image.png') }}"
                                                class="rounded mb-3"
                                                style="width:120px;height:120px;object-fit:cover;">
                                            @endif

                                            <p><strong>Nama:</strong> {{ $s->name }}</p>
                                            <p><strong>Email:</strong> {{ $s->email }}</p>

                                            {{-- JABATAN --}}
                                            <p><strong>Jabatan:</strong> {{ $s->nama_poli }}</p>

                                            <p><strong>Dibuat:</strong> {{ $s->created_at }}</p>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada data Dokter
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