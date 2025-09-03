<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi - {{ $transaksi->invoice }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 20px; }
        .header p { margin: 2px 0; font-size: 12px; }
        .info { margin-bottom: 20px; }
        .info p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #f3f3f3; }
        .summary { text-align: right; margin-top: 10px; }
        .summary p { margin: 2px 0; font-weight: bold; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h2>Sistem Admin Kasir</h2>
        <p>Laporan Detail Transaksi</p>
        <p>Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <!-- Info Transaksi -->
    <div class="info">
        <p><b>Invoice:</b> {{ $transaksi->invoice }}</p>
        <p><b>Tanggal:</b> {{ $transaksi->created_at->format('d-m-Y H:i') }}</p>
        <p><b>Kasir:</b> {{ $transaksi->user->nama ?? '-' }}</p>
        <p><b>Pelanggan:</b> {{ $transaksi->pelanggan->nama ?? 'Umum' }}</p>
        <p><b>Metode Pembayaran:</b> {{ strtoupper($transaksi->metode_pembayaran) }}</p>
    </div>

    <!-- Tabel Produk -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Kode</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $i => $detail)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $detail->produk->nama }}</td>
                <td>{{ $detail->produk->kode_produk }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary">
        <p>Total: Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
        <p>Diskon: Rp {{ number_format($transaksi->diskon ?? 0, 0, ',', '.') }}</p>
        <p><u>Total Pembayaran: Rp {{ number_format($transaksi->total - ($transaksi->diskon ?? 0), 0, ',', '.') }}</u></p>
        <p>Bayar: Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</p>
        <p>Kembali: Rp {{ number_format($transaksi->kembali, 0, ',', '.') }}</p>
    </div>

</body>
</html>
