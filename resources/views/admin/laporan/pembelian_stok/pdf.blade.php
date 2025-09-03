<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #f0f0f0; }
        h2 { margin-bottom: 0; }
    </style>
</head>
<body>
    <h2>Laporan Pembelian</h2>
    <p><small>Periode: {{ $start_date ?? 'Semua' }} s/d {{ $end_date ?? 'hari' }}</small></p>

    <p><b>Total Item:</b> {{ $total_item }} <br>
    <b>Total Nominal:</b> Rp {{ number_format($total_nominal, 0, ',', '.') }}</p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Kode</th>
                <th>Supplier</th>
                <th>Jumlah</th>
                <th>Harga Beli</th>
                <th>Subtotal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $i => $log)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $log->created_at->format('d-m-Y') }}</td>
                    <td>{{ $log->produk->nama ?? '-' }}</td>
                    <td>{{ $log->produk->kode_produk ?? '-' }}</td>
                    <td>{{ $log->produk->suppliers->pluck('nama')->join(', ') }}</td>
                    <td style="text-align: right">{{ $log->jumlah }}</td>
                    <td style="text-align: right">Rp {{ number_format($log->produk->harga_beli, 0, ',', '.') }}</td>
                    <td style="text-align: right">Rp {{ number_format($log->jumlah * $log->produk->harga_beli, 0, ',', '.') }}</td>
                    <td>{{ $log->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
