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
}
