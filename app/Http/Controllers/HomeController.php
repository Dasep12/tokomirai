<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {


        $category = DB::table('mst_category')->get();
        return view('home.index', compact('category'));
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/')->with('error', 'Keranjang kosong');
        }

        $subtotal = collect($cart)->sum(fn($x) => $x['price'] * $x['qty']);
        $tax = round($subtotal * 0.11);
        $total = $subtotal + $tax + 25000;

        return view('home.checkout', compact('cart', 'subtotal', 'tax', 'total'));
    }

    public function servicesJson(Request $request)
    {
        $query = DB::table('mst_services');

        return response()->json($query->get());
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

    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|regex:/^08[0-9]{8,11}$/',
            'email' => 'required|email',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'village' => 'required',
            'postal_code' => 'required|digits:5',
        ], [
            'phone.regex' => 'Nomor harus format Indonesia (08xxxx)',
            'postal_code.digits' => 'Kode pos harus 5 digit'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        DB::beginTransaction();

        try {

            // 🔹 ambil cart dari session
            $cart = session('cart', []);

            if (empty($cart)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart kosong'
                ]);
            }

            // 🔹 generate invoice
            $invoice = 'INV-' . date('YmdHis');

            // 🔹 hitung total
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['qty'];
            }

            // 🔹 hitung subtotal
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['qty'];
            }

            // 🔥 PPN 11%
            $tax = $subtotal * 0.11;

            // 🔹 grand total
            $grandTotal = $subtotal + $tax;

            // 🔹 insert transaksi
            $trxId = DB::table('transactions')->insertGetId([
                'invoice' => $invoice,
                'user_id' => Auth::id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'status' => 'PENDING',

                // 🔥 SIMPAN NAMA (bukan ID)
                'province' => $request->province,
                'city' => $request->city,
                'district' => $request->district,
                'village' => $request->village,

                // 🔥 SIMPAN ID (bukan NAMA)
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,

                'postal_code' => $request->postal_code,

                'total' => $subtotal,
                'tax' => $tax,
                'grand_total' => $grandTotal,

                'created_at' => now()
            ]);

            // 🔹 insert detail
            foreach ($cart as $item) {
                DB::table('transaction_details')->insert([
                    'transaction_id' => $trxId,
                    'product_id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty'],
                    'created_at' => now()
                ]);
            }

            // 🔹 kirim email ke admin
            // $mail_to = setting('email_oder');
            $mail_to = array_map('trim', explode(',', setting('email_oder')));
            Mail::to($mail_to)->send(new OrderMail([
                'invoice' => $invoice,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'province' => $request->province,
                'city' => $request->city,
                'district' => $request->district,
                'village' => $request->village,
                'postal_code' => $request->postal_code,
                'items' => $cart,
                'total' => $subtotal,
                'tax' => $tax,
                'grand_total' => $grandTotal
            ]));

            // 🔹 clear cart
            session()->forget('cart');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil',
                'invoice' => $invoice
            ]);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function ListOrder()
    {
        $transactions = DB::table('transactions')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        foreach ($transactions as $trx) {

            $trx->details = DB::table('transaction_details')
                ->where('transaction_id', $trx->id)
                ->get();
        }
        return view('home.list-order', compact('transactions'));
    }
}
