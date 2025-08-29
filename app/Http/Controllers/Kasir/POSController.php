<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class POSController extends Controller
{

    public function index()
    {
        $produks = Produk::all();
        return view('kasir.transaksi.index', compact('produks'));
    }

    public function byKode(string $kode)
    {
        $produk = Produk::select('id', 'kode_produk', 'nama', 'harga_jual')
            ->where('kode_produk', $kode)
            ->first();

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'produk'  => $produk
        ]);
    }
}
