<h2 style="text-align:center;">Laporan Stok Gudang</h2>
<hr>
<table width="100%" border="1" cellspacing="0" cellpadding="4">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode</th>
            <th>Nama Produk</th>
            <th>Stok</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Nilai Stok</th>
            <th>Supplier</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produks as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $p->kode_produk }}</td>
            <td>{{ $p->nama }}</td>
            <td>{{ $p->stok }}</td>
            <td>Rp {{ number_format($p->harga_beli) }}</td>
            <td>Rp {{ number_format($p->harga_jual) }}</td>
            <td>Rp {{ number_format($p->stok * $p->harga_beli) }}</td>
            <td>{{ $p->suppliers->pluck('nama')->implode(', ') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
