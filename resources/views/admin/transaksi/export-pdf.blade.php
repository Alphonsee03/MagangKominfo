<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { margin-bottom: 2px; }
        .header { text-align: center; margin-bottom: 15px; }
        .header h2 { margin: 0; font-size: 16px; }
        .periode { font-size: 11px; color: #555; }

        .summary {
            display: table;
            width: 100%;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .summary div {
            display: table-cell;
            padding: 8px;
            border-right: 1px solid #ccc;
            text-align: center;
        }
        .summary div:last-child { border-right: none; }
        .summary p { margin: 2px 0; font-size: 11px; }
        .summary b { display: block; font-size: 13px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px; }
        thead { background: #f2f2f2; }
        th, td { padding: 6px 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { font-size: 12px; }
        td { font-size: 11px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Transaksi</h2>
        <div class="periode">Periode: {{ $start_date ?? '-' }} s/d {{ $end_date ?? '-' }}</div>
    </div>

    <!-- Summary -->
    <div class="summary">
        <div>
            <b>{{ $summary['jumlah_transaksi'] }}</b>
            <p>Jumlah Transaksi</p>
        </div>
        <div>
            <b>Rp {{ number_format($summary['omzet'], 0, ',', '.') }}</b>
            <p>Omzet</p>
        </div>
        <div>
            <b>Rp {{ number_format($summary['total_bayar'], 0, ',', '.') }}</b>
            <p>Total Bayar</p>
        </div>
        <div>
            <b>Rp {{ number_format($summary['total_kembali'], 0, ',', '.') }}</b>
            <p>Total Kembali</p>
        </div>
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Kasir</th>
                <th>Pelanggan</th>
                <th class="text-right">Total</th>
                <th class="text-right">Diskon</th>
                <th class="text-right">Bayar</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $t)
            <tr>
                <td>{{ \Carbon\Carbon::parse($t->created_at)->format('d-m-Y H:i') }}</td>
                <td>{{ $t->invoice }}</td>
                <td>{{ $t->user->nama ?? '-' }}</td>
                <td>{{ $t->pelanggan->nama ?? 'Umum' }}</td>
                <td class="text-right">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($t->diskon ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($t->bayar, 0, ',', '.') }}</td>
                <td>{{ strtoupper($t->metode_pembayaran) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
