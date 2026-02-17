@extends('layouts.app')

@section('content')

<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Riwayat Berobat Pasien</h4>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pasien</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($riwayat as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kode_pasien }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime($item->tanggal)) }}</td>
                                <td>
                                    @if($item->status_kunjungan == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                    @elseif($item->status_kunjungan == 'Proses')
                                    <span class="badge bg-warning text-dark">Proses</span>
                                    @else
                                    <span class="badge bg-secondary">
                                        {{ $item->status_kunjungan }}
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <button
                                        class="btn btn-primary btn-sm"
                                        onclick="showDetail('{{ $item->id }}')">
                                        Detail
                                    </button>
                                    <button
                                        class="btn btn-success btn-sm"
                                        onclick="printRiwayat('{{ $item->id }}')"
                                        <i class="bi bi-printer"></i> Print
                                    </button>

                                </td>

                            </tr>

                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data riwayat
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

<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-file-medical me-2"></i> Detail Riwayat Pasien
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="container-fluid">

                    <div class="row">

                        <!-- DATA PASIEN -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-light fw-bold text-primary">
                                    Data Pasien
                                </div>
                                <div class="card-body small">
                                    <p><b>Nama:</b> <span id="nama"></span></p>
                                    <p><b>Umur:</b> <span id="umur"></span></p>
                                    <p><b>Alamat:</b> <span id="alamat"></span></p>
                                    <p><b>Kelurahan:</b> <span id="kelurahan"></span></p>
                                    <p><b>Kecamatan:</b> <span id="kecamatan"></span></p>
                                    <p><b>Provinsi:</b> <span id="provinsi"></span></p>
                                    <p><b>Kode Pos:</b> <span id="kode_pos"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- DATA PEMERIKSAAN -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-light fw-bold text-primary">
                                    Data Pemeriksaan
                                </div>
                                <div class="card-body small">
                                    <p><b>Tinggi:</b> <span id="tinggi"></span> cm</p>
                                    <p><b>Berat:</b> <span id="berat"></span> kg</p>
                                    <p><b>Tensi:</b> <span id="tensi"></span></p>
                                    <p><b>Suhu:</b> <span id="suhu"></span></p>
                                    <p class="mb-1"><b>Keluhan :</b></p>
                                    <div class="border rounded p-2 bg-light" id="keluhan"></div>
                                    <p class="mb-1"><b>Catatan Dokter:</b></p>
                                    <div class="border rounded p-2 bg-light" id="catatan_obat"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- OBAT -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light fw-bold text-primary">
                                    Obat Diberikan
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama Obat</th>
                                                    <th width="100">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail_obat"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>
</div>


<script>
    function showDetail(id) {
        fetch(`/Riwayat/detail/${id}`)
            .then(response => response.json())
            .then(data => {

                document.getElementById('nama').innerText = data.pasien?.nama ?? '-';
                document.getElementById('umur').innerText = data.pasien?.umur ?? '-';
                document.getElementById('alamat').innerText = data.pasien?.alamat ?? '-';
                document.getElementById('kelurahan').innerText = data.pasien?.kelurahan ?? '-';
                document.getElementById('kecamatan').innerText = data.pasien?.kecamatan ?? '-';
                document.getElementById('provinsi').innerText = data.pasien?.provinsi ?? '-';
                document.getElementById('kode_pos').innerText = data.pasien?.kode_post ?? '-';
                document.getElementById('tinggi').innerText = data.pemeriksaan?.tinggi_badan ?? '-';
                document.getElementById('berat').innerText = data.pemeriksaan?.berat_badan ?? '-';
                document.getElementById('tensi').innerText = data.pemeriksaan?.tensi ?? '-';
                document.getElementById('suhu').innerText = data.pemeriksaan?.suhu_badan ?? '-';
                document.getElementById('keluhan').innerText = data.pemeriksaan?.keluhan ?? '-';
                document.getElementById('catatan_obat').innerText = data.pemeriksaan?.catatan_obat ?? '-';


                let detailTable = document.getElementById('detail_obat');
                detailTable.innerHTML = '';

                if (data.detail_obat.length > 0) {
                    data.detail_obat.forEach(item => {
                        detailTable.innerHTML += `
                        <tr>
                            <td>${item.nama_obat}</td>
                            <td>${item.jumlah}</td>
                        </tr>
                    `;
                    });
                } else {
                    detailTable.innerHTML = `
                    <tr>
                        <td colspan="2" class="text-center text-muted">
                            Tidak ada obat
                        </td>
                    </tr>
                `;
                }

                new bootstrap.Modal(document.getElementById('detailModal')).show();
            });
    }
</script>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #printArea,
        #printArea * {
            visibility: visible;
        }

        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>

<script>
    function printRiwayat(id) {

        fetch(`/Riwayat/print/${id}`)
            .then(response => response.text())
            .then(html => {

                let printDiv = document.createElement('div');
                printDiv.id = 'printArea';
                printDiv.innerHTML = html;

                document.body.appendChild(printDiv);

                window.print();

                document.body.removeChild(printDiv);
            });
    }
</script>

@endsection