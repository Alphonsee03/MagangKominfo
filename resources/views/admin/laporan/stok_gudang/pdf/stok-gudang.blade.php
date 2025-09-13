<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Gudang</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; color: #2d4739; }
        .header p { margin: 4px 0; font-size: 11px; color: #666; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead { background: #f2f2f2; }
        th, td { padding: 8px 6px; font-size: 11px; }
        th { text-align: left; font-weight: bold; border-bottom: 2px solid #2d4739; }
        td { border-bottom: 1px solid #ddd; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .summary { margin-top: 15px; font-size: 12px; }
        .summary p { margin: 3px 0; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h2>Laporan Stok Gudang</h2>
        <p>Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th>Kode</th>
                <th>Nama Produk</th>
                <th class="text-center">Stok</th>
                <th class="text-right">Harga Beli</th>
                <th class="text-right">Harga Jual</th>
                <th class="text-right">Nilai Stok</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produks as $i => $p)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $p->kode_produk }}</td>
                <td>{{ $p->nama }}</td>
                <td class="text-center">{{ $p->stok }}</td>
                <td class="text-right">Rp {{ number_format($p->harga_beli, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($p->stok * $p->harga_beli, 0, ',', '.') }}</td>
                <td>{{ $p->suppliers->pluck('nama')->implode(', ') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Optional Summary -->
    <div class="summary">
        <p><b>Total Produk:</b> {{ count($produks) }}</p>
        <p><b>Total Nilai Stok:</b> 
            Rp {{ number_format($produks->sum(fn($p) => $p->stok * $p->harga_beli), 0, ',', '.') }}
        </p>
    </div>

</body>
</html>
