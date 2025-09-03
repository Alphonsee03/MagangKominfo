<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Profit</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
        .summary { margin-bottom: 15px; }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Laporan Profit</h2>
    <p><small>Periode: {{ $start_date ?? 'Awal' }} s/d {{ $end_date ?? 'Akhir' }}</small></p>

    <!-- Summary -->
    <div class="summary">
        <p><b>Total Penjualan:</b> Rp {{ number_format($summary['total_penjualan'],0,',','.') }}</p>
        <p><b>Total Modal:</b> Rp {{ number_format($summary['total_modal'],0,',','.') }}</p>
        <p><b>Profit Bersih:</b> Rp {{ number_format($summary['profit'],0,',','.') }}</p>
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Invoice</th>
                <th>Tanggal</th>            
                <th>Kasir</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Subtotal</th>
                <th>Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $i => $row)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $row['invoice'] }}</td>
                <td>{{ $row['tanggal'] }}</td>
                <td>{{ $row['kasir'] }}</td>
                <td>{{ $row['produk'] }}</td>
                <td>{{ $row['qty'] }}</td>
                <td>Rp {{ number_format($row['harga_beli'],0,',','.') }}</td>
                <td>Rp {{ number_format($row['harga_jual'],0,',','.') }}</td>
                <td>Rp {{ number_format($row['subtotal'],0,',','.') }}</td>
                <td>Rp {{ number_format($row['profit'],0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
