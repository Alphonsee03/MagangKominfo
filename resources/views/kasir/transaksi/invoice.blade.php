<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mb-1 {
            margin-bottom: 4px;
        }

        .mb-2 {
            margin-bottom: 24px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 2px 0;
        }

        .w-qty {
            width: 20px;
            text-align: center;
        }

        .w-price {
            width: 60px;
            text-align: right;
        }

        .w-subtotal {
            width: 70px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="text-center mb-2 ">
        <strong>TOKO SEMBAKO 25jam</strong><br>
        Jl. Diponogoro No. 25, Kota Sumenep<br>
        WA:0821-3467-4509
    </div>

    <div class="divider "></div>

    <div class="mb-1">Invoice: <strong>{{ $transaksi->invoice }}</strong></div>
    <div class="mb-1">Tanggal: {{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
    <div class="mb-1">Kasir: {{ $transaksi->user->nama ?? '-' }}</div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <td><strong>Item</strong></td>
                <td class="w-qty"><strong>Qty</strong></td>
                <td class="w-price"><strong>Harga</strong></td>
                <td class="w-subtotal"><strong>Total</strong></td>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $item)
            <tr>
                <td>{{ $item->produk->nama }}</td>
                <td class="w-qty">{{ $item->jumlah }}</td>
                <td class="w-price">{{ number_format($item->harga_jual,0,',','.') }}</td>
                <td class="w-subtotal">{{ number_format($item->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <table>
        <th>

        </th>
        <tr>
            <td>Total</td>
            <td class="w-subtotal"><strong>{{ number_format($transaksi->total,0,',','.') }}</strong></td>
        </tr>
        <tr>
            <td>Diskon</td>
            <td class="w-subtotal">-{{ number_format($transaksi->diskon ?? 0,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Total Bayar</td>
            <td class="w-subtotal"><strong>{{ number_format(($transaksi->total - ($transaksi->diskon ?? 0)),0,',','.') }}</strong></td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td class="w-subtotal">{{ number_format($transaksi->bayar,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="w-subtotal">{{ number_format($transaksi->kembali,0,',','.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center">
        Terima kasih telah berbelanja <br>
        Barang yang sudah dibeli tidak dapat dikembalikan. <br>
        --- Simpan struk ini sebagai bukti --- 
        
    </div>

</body>

</html>