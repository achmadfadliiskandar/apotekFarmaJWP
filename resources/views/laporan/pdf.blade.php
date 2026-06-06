<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Mutasi Stok Obat</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 11px;
        }
        .meta-info {
            margin-bottom: 15px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
            font-size: 10px;
        }
        .text-center { text-align: center; }
        .text-success { color: #2e7d32; font-weight: bold; }
        .text-danger { color: #c62828; font-weight: bold; }
        .badge {
            padding: 3px 6px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 3px;
            text-transform: uppercase;
        }
        .bg-masuk { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        .bg-keluar { background-color: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        .footer-tanggal {
            text-align: right;
            font-size: 10px;
            color: #777;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Sistem Informasi Inventaris Apotek</h2>
        <p>Rekapitulasi Data Arus Mutasi Keluar Masuk Komoditas Obat</p>
    </div>

    <div class="meta-info">
        <strong>Dokumen:</strong> Laporan Mutasi Stok Obat<br>
        <strong>Waktu Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 40px;">No</th>
                <th>Daftar Obat ID</th>
                <th>Nama Obat</th>
                <th>User ID</th>
                <th>Nama Petugas</th>
                <th class="text-center" style="width: 90px;">Jenis</th>
                <th class="text-center" style="width: 70px;">Jumlah</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($semuaMutasi as $index => $mutasi)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $mutasi->daftar_obats_id }}</td>
                    <td style="font-weight: bold;">{{ $mutasi->daftarObat->nama_obat ?? 'Obat Tidak Ditemukan' }}</td>
                    <td class="text-center">{{ $mutasi->user_id }}</td>
                    <td>{{ $mutasi->user->name ?? 'System' }}</td>
                    <td class="text-center">
                        @if($mutasi->jenis == 'masuk')
                            <span class="badge bg-masuk">masuk</span>
                        @else
                            <span class="badge bg-keluar">keluar</span>
                        @endif
                    </td>
                    <td class="text-center {{ $mutasi->jenis == 'masuk' ? 'text-success' : 'text-danger' }}">
                        {{ $mutasi->jenis == 'masuk' ? '+' : '-' }}{{ $mutasi->jumlah }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($mutasi->tanggal)->translatedFormat('d-m-Y') }}</td>
                    <td>{{ $mutasi->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 30px; color: #999;">
                        Tidak ada record rekonsiliasi data mutasi obat yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-tanggal">
        Dokumen ini dicetak otomatis secara digital oleh sistem aplikasi inventaris apotek.
    </div>

</body>
</html>