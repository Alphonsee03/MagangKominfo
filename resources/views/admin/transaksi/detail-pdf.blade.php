<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $transaksi->invoice }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h1 { font-size: 22px; margin: 0; color: #2d4739; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
        .header .title { flex: 1; }
        .header .logo { text-align: right; font-size: 14px; font-weight: bold; }
        
        .info { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info div { width: 32%; }
        .info p { margin: 3px 0; font-size: 12px; }
        .info b { display: inline-block; min-width: 90px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead th { text-align: left; font-size: 12px; border-bottom: 2px solid #2d4739; padding: 6px 4px; }
        tbody td { padding: 6px 4px; border-bottom: 1px solid #ddd; font-size: 12px; }
        .text-right { text-align: right; }

        .summary { width: 40%; margin-left: auto; }
        .summary table { width: 100%; border-collapse: collapse; }
        .summary td { padding: 4px 0; font-size: 12px; }
        .summary tr td:first-child { text-align: left; }
        .summary tr td:last-child { text-align: right; }
        .summary .total { font-weight: bold; border-top: 2px solid #2d4739; padding-top: 6px; font-size: 13px; }

        .thanks { text-align: center; margin-top: 30px; font-size: 12px; color: #2d4739; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="title">
            <h1>INVOICE</h1>
            <p>No. Invoice: <b>{{ $transaksi->invoice }}</b></p>
            <p>Date: {{ $transaksi->created_at->format('d M Y H:i') }}</p>
            <p>Payment Method: {{ strtoupper($transaksi->metode_pembayaran) }}</p>
        </div>
        <div class="logo">
            CHASIFY MODERN POS
        </div>
    </div>

    <!-- Info Transaksi -->
    <div class="info">
        <div>
            <b>Kasir:</b> {{ $transaksi->user->nama ?? '-' }}<br>
            <b>Pelanggan:</b> {{ $transaksi->pelanggan->nama ?? 'Umum' }}
        </div>
        <div>
            <b>Alamat Toko:</b><br>
            Jl. Diponogoro No.25  <br>
            Kota Sumenep - Madura<br>
        </div>
        <div>
            <b>Telp:</b> 0812-3456-7890<br>
            <b>Email:</b> toko@sembako25jam.com
        </div>
    </div>

    <!-- Tabel Produk -->
    <table>
        <thead>
            <tr>
            <th style="width: 40%;">Items</th>
            <th style="width: 15%;">Qty</th>
            <th style="width: 22.5%;">Price</th>
            <th style="width: 22.5%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $detail)
            <tr>
            <td style="width: 40%;">{{ $detail->produk->nama }}</td>
            <td style="width: 15%;">{{ $detail->jumlah }}</td>
            <td style="width: 22.5%;">Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
            <td style="width: 22.5%;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary">
        <table>
            <tr>
                <td>Subtotal</td>
                <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Diskon</td>
                <td>- Rp {{ number_format($transaksi->diskon ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td>Rp {{ number_format($transaksi->kembali, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="total">TOTAL</td>
                <td class="total">Rp {{ number_format($transaksi->total - ($transaksi->diskon ?? 0), 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>



</body>
</html>
