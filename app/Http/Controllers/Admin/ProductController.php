<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductImage;



class ProductController extends Controller
{
    //
    public function products(Request $request)
    {
        $perPage = $request->get('show', 10);
        $search = $request->get('search');
        $query = Product::query()
            ->leftJoin(
                'mst_category',
                'mst_product.category',
                '=',
                'mst_category.id'
            )
            ->select(
                'mst_product.*',
                'mst_category.name_category as category_name'
            );
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('mst_category.name_category', 'LIKE', "%{$search}%");
            });
        }
        $products = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // AJAX REQUEST
        if ($request->ajax()) {

            return view(
                'admin.product.partials.table',
                compact('products')
            )->render();
        }
        return view(
            'admin.product.index',
            compact('products')
        );
    }

    public function loadcategory()
    {
        $categories = DB::table('mst_category')->get();
        return response()->json($categories);
    }

    public function detail(Request $request)
    {
        $id = $request->get('id');
        $product = Product::find($id);
        $productImage = ProductImage::where('product_id', $id)->get(); // Eager load gallery untuk menghindari N+1 problem

        if ($product) {
            return response()->json([
                'product' => $product,
                'images' => $productImage
            ]);
        } else {
            return response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
    }

    public function crud(Request $request)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();
            $action = $request->get('crud-action');
            switch ($action) {
                case 'create':
                    $product = new Product();
                    break;
                case 'update':
                    $id = $request->get('id');
                    $product = Product::find($id);
                    if (!$product) {
                        return response()->json([
                            'message' => 'Produk tidak ditemukan'
                        ], 404);
                    }
                    break;
                case 'delete':
                    $id = $request->get('id');
                    ProductImage::where(
                        'product_id',
                        $id
                    )->delete();
                    $product = Product::find($id);
                    if (!$product) {
                        return response()->json([
                            'message' => 'Produk tidak ditemukan'
                        ], 404);
                    }
                    $product->delete();
                    DB::commit();
                    return response()->json([
                        'message' => 'Produk berhasil dihapus'
                    ]);
                    break;
                default:
                    return response()->json([
                        'message' => 'Aksi tidak valid'
                    ], 400);
            }

            // save create & update
            $product->name = $request->name;
            $product->category = $request->category;
            $product->price = $request->price;
            $product->discount = $request->discount;
            $product->badge = $request->badge;
            if ($request->hasFile('cover_image')) {
                $destination = public_path('assets/images/products');
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }
                $file_cover = $request->file('cover_image');
                if (!$file_cover->isValid()) {
                    throw new \Exception('File cover image tidak valid');
                }
                $filename_cover_image =
                    time() . '_' .
                    uniqid() . '.' .
                    $file_cover->getClientOriginalExtension();
                $file_cover->move($destination, $filename_cover_image);
                $product->images = $filename_cover_image;
            }
            $product->description = $request->description;
            $product->spesification = array_values(
                array_filter($request->spesification)
            );

            $product->save();
            // =========================
            // HANDLE IMAGE
            // =========================
            // image lama yang masih dipertahankan
            $keepImages = $request->old_images ?? [];


            // =========================
            // DELETE REMOVED IMAGE
            // =========================
            if ($action == 'update') {
                $deletedImages = ProductImage::where('product_id', $product->id)
                    ->whereNotIn('id', $keepImages)
                    ->get();
                foreach ($deletedImages as $img) {
                    $filePath = public_path($img->path);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $img->delete();
                }
            }


            // =========================
            // UPLOAD NEW IMAGE
            // =========================
            if ($request->hasFile('images')) {
                $destination = public_path('assets/images/products');
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }
                foreach ($request->file('images') as $file) {
                    if (!$file->isValid()) {
                        continue;
                    }
                    $filename =
                        time() . '_' .
                        uniqid() . '.' .
                        $file->getClientOriginalExtension();
                    $file->move($destination, $filename);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'name' => $filename,
                        'path' => 'assets/images/products/' . $filename,
                        'created_at' => now(),
                        'created_by' => auth()->user()->name ?? 'system'
                    ]);
                }
            }


            DB::commit();
            return response()->json([
                'message' => $action == 'create'
                    ? 'Produk berhasil ditambahkan'
                    : 'Produk berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
