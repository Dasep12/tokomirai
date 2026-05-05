<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index()
    {
        return view('home.index');
    }

    public function productJson(Request $request)
    {
        $query = DB::table('mst_product');

        // filter category
        if ($request->category && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('spesification', 'like', '%' . $request->search . '%');
            });
        }

        return response()->json($query->get());
    }

    public function productJsonDetail(Request $request)
    {
        $product = DB::table('mst_product')->where('id', $request->id);
        return view('home.product-detail', compact('product'));
    }

    public function productListJsonDetail(Request $request)
    {
        $product = DB::table('mst_product')
            ->where('id', $request->id)
            ->first();

        $images = DB::table('mst_product_image')
            ->where('product_id', $request->id)
            ->get();

        if ($product) {
            // 🔥 FIX PRICE (AMAN)
            $product->price = (int) str_replace(',', '', $product->price ?? 0);
            // 🔥 FIX SPEC (ANTI ERROR)
            if (!empty($product->spesification)) {
                $decoded = json_decode($product->spesification, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $product->spesification = $decoded;
                } else {
                    // fallback kalau format jelek
                    $product->spesification = [];
                }
            } else {
                $product->spesification = [];
            }
        }
        return response()->json([
            'product' => $product,
            'images' => $images
        ]);
    }

    public function get()
    {
        $cart = session()->get('cart', []);

        return response()->json([
            'cart' => $cart,
            'total_qty' => collect($cart)->sum('qty')
        ]);
    }

    public function add(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->product_id;
        $qty = $request->qty ?? 1;

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            // ambil dari DB (optional tapi lebih aman)
            $product = DB::table('mst_product')
                ->where('id', $id)->select('*')->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan'
                ]);
            }

            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $qty,
                'image' => $product->images
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'total_qty' => collect($cart)->sum('qty'),
            'cart' => $cart
        ]);
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->product_id;
        $qty = $request->qty;

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'total_qty' => collect($cart)->sum('qty')
        ]);
    }
}
