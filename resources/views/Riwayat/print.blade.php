<!DOCTYPE html>
<html>

<head>
    <title>Print Riwayat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .line {
            border-top: 2px solid black;
            margin: 10px 0 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
        }

        .no-border td {
            border: none;
            padding: 4px 0;
        }

        .text-right {
            text-align: right;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="header">
        <h2>KLINIK SEHAT SENTOSA</h2>
        <p>Jl. Contoh No.123 - Indonesia</p>
    </div>

    <div class="line"></div>

    <h4>Data Pasien</h4>
    <table class="no-border">
        <tr>
            <td width="150">Kode Pasien</td>
            <td>: {{ $pasien->kode_pasien }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $pasien->nama }}</td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>: {{ $pasien->umur }} Tahun</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $pasien->alamat }}</td>
        </tr>
    </table>

    <br>

    <h4>Data Pemeriksaan</h4>
    <table class="no-border">
        <tr>
            <td width="150">Tanggal</td>
            <td>: {{ date('d-m-Y H:i', strtotime($riwayat->tanggal)) }}</td>
        </tr>
        <tr>
            <td>Tinggi</td>
            <td>: {{ $pemeriksaan->tinggi_badan }} cm</td>
        </tr>
        <tr>
            <td>Berat</td>
            <td>: {{ $pemeriksaan->berat_badan }} kg</td>
        </tr>
        <tr>
            <td>Tensi</td>
            <td>: {{ $pemeriksaan->tensi }}</td>
        </tr>
        <tr>
            <td>Suhu</td>
            <td>: {{ $pemeriksaan->suhu_badan }}</td>
        </tr>
        <tr>
            <td>Keluhan</td>
            <td>: {{ $pemeriksaan->keluhan }}</td>
        </tr>
        <tr>
            <td>Catatan Dokter</td>
            <td>: {{ $pemeriksaan->catatan_obat }}</td>
        </tr>
    </table>

    <br>

    <h4>Obat Diberikan</h4>
    <table>
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th width="100">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detail as $d)
            <tr>
                <td>{{ $d->nama_obat }}</td>
                <td>{{ $d->jumlah }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" align="center">Tidak ada obat</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <br><br>

    <div class="text-right">
        <p>Dokter Pemeriksa</p>
        <br><br><br>
        <p>( {{ $dokter->name }} )</p>
    </div>

</body>

</html>