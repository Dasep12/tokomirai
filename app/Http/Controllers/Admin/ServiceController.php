<?php

namespace App\Http\Controllers\Admin;

use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    //
    public function services(Request $request)
    {
        $perPage = $request->get('show', 10);
        $search = $request->get('search');
        $query = Services::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('mst_category.name_category', 'LIKE', "%{$search}%");
            });
        }
        $services = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // AJAX REQUEST
        if ($request->ajax()) {
            return view(
                'admin.service.partials.table',
                compact('services')
            )->render();
        }
        return view(
            'admin.service.index',
            compact('services')
        );
    }

    public function detail(Request $request)
    {
        $id = $request->input('id');
        $service = Services::find($id);
        return response()->json(['service' => $service]);
    }

    public function crud(Request $request)
    {
        $id = $request->input('id');
        try {
            DB::beginTransaction();
            $service = Services::find($id);
            switch ($request->input('crud-action')) {
                case 'create':
                    // CREATE
                    Services::create([
                        'name' => $request->input('name'),
                        'price' => $request->input('price'),
                        'description' => $request->input('description'),
                        'icon' => $request->input('icon'),
                        'is_active' => $request->input('is_active')  ? 1 : 0,
                    ]);
                    break;
                case 'update':
                    // UPDATE
                    $service->name = $request->input('name');
                    $service->price = $request->input('price');
                    $service->description = $request->input('description');
                    $service->icon = $request->input('icon');
                    $service->is_active = $request->input('is_active') ? 1 : 0;
                    $service->save();
                    break;
                case 'delete':
                    // DELETE
                    $service->delete();
                    break;
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
