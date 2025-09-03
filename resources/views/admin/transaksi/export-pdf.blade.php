<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 6px; text-align: left; }
        .summary { margin-bottom: 15px; }
        .summary p { margin: 2px 0; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <p><small>Periode: {{ $start_date ?? '-' }} s/d {{ $end_date ?? '-' }}</small></p>

    <!-- Summary -->
    <div class="summary">
        <p><b>Jumlah Transaksi:</b> {{ $summary['jumlah_transaksi'] }}</p>
        <p><b>Omzet:</b> Rp {{ number_format($summary['omzet'], 0, ',', '.') }}</p>
        <p><b>Total Bayar:</b> Rp {{ number_format($summary['total_bayar'], 0, ',', '.') }}</p>
        <p><b>Total Kembali:</b> Rp {{ number_format($summary['total_kembali'], 0, ',', '.') }}</p>
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Kasir</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Diskon</th>
                <th>Bayar</th>
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
                <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($t->diskon ?? 0, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($t->bayar, 0, ',', '.') }}</td>
                <td>{{ strtoupper($t->metode_pembayaran) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
