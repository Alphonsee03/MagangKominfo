<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCart()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_column($cart, 'subtotal'));

        return response()->json([
            'cart' => $cart,
            'total' => $total
        ]);
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|string',
            'qty' => 'required|integer|min:1'
        ]);

        $produk = Produk::where('kode_produk', $request->kode_produk)->first();
        if (!$produk) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$produk->id])) {
            $cart[$produk->id]['qty'] += (int)$request->qty;
            $cart[$produk->id]['subtotal'] = $cart[$produk->id]['qty'] * $produk->harga_jual;
        } else {
            $cart[$produk->id] = [
                'produk_id' => $produk->id,
                'kode' => $produk->kode_produk,
                'nama' => $produk->nama,
                'harga' => $produk->harga_jual,
                'qty' => (int)$request->qty,
                'subtotal' => $produk->harga_jual * (int)$request->qty,
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['success' => 'Produk ditambahkan ke cart']);
    }

    public function updateQty(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json(['error' => 'Produk tidak ada di cart'], 404);
        }

        $cart[$id]['qty'] = (int)$request->qty;
        $cart[$id]['subtotal'] = $cart[$id]['qty'] * $cart[$id]['harga'];

        session()->put('cart', $cart);

        return response()->json(['success' => 'Qty diperbarui']);
    }

    public function removeItem($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json(['success' => 'Produk dihapus dari cart']);
    }

    public function resetCart()
    {
        session()->forget('cart');
        return response()->json(['success' => 'Cart dikosongkan']);
    }
}
