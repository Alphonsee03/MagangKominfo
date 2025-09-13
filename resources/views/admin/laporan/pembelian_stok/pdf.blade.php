<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; color: #2d4739; }
        .header p { margin: 4px 0; font-size: 11px; color: #666; }

        .summary { margin-bottom: 15px; font-size: 12px; }
        .summary p { margin: 3px 0; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead { background: #f2f2f2; }
        th, td { padding: 8px 6px; font-size: 11px; }
        th { text-align: center; font-weight: bold; border-bottom: 2px solid #2d4739; }
        td { border-bottom: 1px solid #ddd; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h2>Laporan Pembelian Stok Produk</h2>
        <p>Periode: {{ $start_date ?? 'Semua' }} s/d {{ $end_date ?? 'Hari Ini' }}</p>
        <p>Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <!-- Summary -->
    <div class="summary">
        <p><b>Total Item Dibeli:</b> {{ $total_item }}</p>
        <p><b>Total Nominal:</b> Rp {{ number_format($total_nominal, 0, ',', '.') }}</p>
    </div>

    <!-- Table -->
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
                    <td class="text-center">{{ $i+1 }}</td>
                    <td class="text-center">{{ $log->created_at->format('d-m-Y') }}</td>
                    <td>{{ $log->produk->nama ?? '-' }}</td>
                    <td>{{ $log->produk->kode_produk ?? '-' }}</td>
                    <td>{{ $log->produk->suppliers->pluck('nama')->join(', ') }}</td>
                    <td class="text-right">{{ $log->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($log->produk->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($log->jumlah * $log->produk->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $log->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
