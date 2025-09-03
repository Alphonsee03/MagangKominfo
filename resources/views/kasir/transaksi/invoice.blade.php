<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 4px; border-bottom: 1px solid #ddd; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
    @vite('resources/css/app.css')
</head>
<body>
    <h3 class="text-center">Toko Kamu</h3>
    <p class="text-center">Jl. Contoh No. 123</p>
    <hr>

    <p>Invoice: <strong>{{ $transaksi->invoice }}</strong></p>
    <p>Tanggal: {{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
    <p>Kasir: {{ $transaksi->user->nama ?? '-' }}</p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $item)
                <tr>
                    <td>{{ $item->produk->nama }}</td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td class="text-right">{{ number_format($item->harga_jual,0,',','.') }}</td>
                    <td class="text-right">{{ number_format($item->subtotal,0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>
    <p class="text-right">Total: <strong>{{ number_format($transaksi->total,0,',','.') }}</strong></p>
    <p class="text-right">Diskon: {{ number_format($transaksi->diskon ?? 0,0,',','.') }}</p>
    <p class="text-right">Total Pembayaran: {{ number_format($transaksi->total - $transaksi->diskon ?? 0,0,',','.') }}</p>
    <p class="text-right">Bayar: {{ number_format($transaksi->bayar,0,',','.') }}</p>
    <p class="text-right">Kembali: {{ number_format($transaksi->kembali,0,',','.') }}</p>

    <hr>
    <p class="text-center">Terima kasih telah berbelanja 🙏</p>
</body>
</html>
