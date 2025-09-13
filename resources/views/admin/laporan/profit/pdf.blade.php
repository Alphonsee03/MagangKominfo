<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Profit</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; color: #2d4739; }
        .header p { margin: 4px 0; font-size: 11px; color: #666; }

        .summary { margin-bottom: 15px; font-size: 12px; }
        .summary p { margin: 3px 0; }
        .highlight { font-weight: bold; color: #2d4739; }

        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        thead { background: #f2f2f2; }
        th, td { padding: 8px 6px; font-size: 11px; }
        th { text-align: center; font-weight: bold; border-bottom: 2px solid #2d4739; }
        td { border-bottom: 1px solid #ddd; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h2>Laporan Profit</h2>
        <p>Periode: {{ $start_date ?? 'Awal' }} s/d {{ $end_date ?? 'Akhir' }}</p>
        <p>Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <!-- Summary -->
    <div class="summary">
        <p><b>Total Penjualan:</b> Rp {{ number_format($summary['total_penjualan'],0,',','.') }}</p>
        <p><b>Total Modal:</b> Rp {{ number_format($summary['total_modal'],0,',','.') }}</p>
        <p><b>Total Transaksi:</b> Rp {{ number_format($summary['total_transaksi'],0,',','.') }}</p>
        <p class="highlight"><b>Profit Bersih:</b> Rp {{ number_format($summary['profit'],0,',','.') }}</p>
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
                <td class="text-center">{{ $i+1 }}</td>
                <td class="text-center">{{ $row['invoice'] }}</td>
                <td class="text-center">{{ $row['tanggal'] }}</td>
                <td class="text-center">{{ $row['kasir'] }}</td>
                <td>{{ $row['produk'] }}</td>
                <td class="text-center">{{ $row['qty'] }}</td>
                <td class="text-right">Rp {{ number_format($row['harga_beli'],0,',','.') }}</td>
                <td class="text-right">Rp {{ number_format($row['harga_jual'],0,',','.') }}</td>
                <td class="text-right">Rp {{ number_format($row['subtotal'],0,',','.') }}</td>
                <td class="text-right highlight">Rp {{ number_format($row['profit'],0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
