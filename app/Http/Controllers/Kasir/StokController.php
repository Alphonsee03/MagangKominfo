<?php
namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('nama')->get();
        $countProduk = Produk::count();
        return view('kasir.gudang.index', compact('suppliers', 'countProduk'));
    }

    public function data(Request $request)
    {
        $query = Produk::with('suppliers');

        // 🔎 search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_produk', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        // 📌 filter supplier
        if ($request->filled('supplier_id')) {
            $query->whereHas('suppliers', function ($q) use ($request) {
                $q->where('suppliers.id', $request->supplier_id);
            });
        }

        $sortBy = $request->get('sort_by', 'nama');
        $sortOrder = $request->get('sort_order', 'asc');
        $allowedSort = ['nama', 'stok', 'harga_jual'];
        if (!in_array($sortBy, $allowedSort)) {
            $sortBy = 'nama';
            $sortOrder = 'asc';
        }

        $produks = $query->orderBy($sortBy, $sortOrder)->paginate(15);

        $produks->getCollection()->transform(function ($produk) {
            return [
                'id'          => $produk->id,
                'kode_produk' => $produk->kode_produk,
                'nama'        => $produk->nama,
                'stok'        => $produk->stok,
                'harga_jual'  => $produk->harga_jual,
                'suppliers'   => $produk->suppliers->pluck('nama')->toArray(),
            ];
        });

        return response()->json($produks);
    }
}

