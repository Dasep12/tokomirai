<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('show', 10);
        $search = $request->get('search');
        $query = Setting::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('values', 'LIKE', "%{$search}%");
            });
        }
        $settings = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // AJAX REQUEST
        if ($request->ajax()) {
            return view(
                'admin.setting.partials.table',
                compact('settings')
            )->render();
        }
        return view(
            'admin.setting.index',
            compact('settings')
        );
    }

    public function detail(Request $request)
    {
        $id = $request->input('id');
        $settings = Setting::find($id);
        return response()->json(['setting' => $settings]);
    }

    public function crud(Request $request)
    {
        $id = $request->input('id');
        try {
            DB::beginTransaction();
            $setting = Setting::find($id);
            $filename_logo = '';
            if ($request->hasFile('images')) {
                $destination = public_path('assets/images/logo');
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }
                $file_logo = $request->file('images');
                if (!$file_logo->isValid()) {
                    throw new \Exception('File  image tidak valid');
                }
                $filename_logo =
                    time() . '_' .
                    uniqid() . '.' .
                    $file_logo->getClientOriginalExtension();
                $file_logo->move($destination, $filename_logo);
                $setting->images = $filename_logo;
            }
            switch ($request->input('crud-action')) {
                case 'create':
                    // CREATE
                    Setting::create([
                        'key' => $request->input('key'),
                        'values' => $request->input('values'),
                        'remarks' => $request->input('remarks'),
                        'images' => $filename_logo,
                    ]);
                    break;
                case 'update':
                    // UPDATE
                    $setting->key = $request->input('key');
                    $setting->values = $request->input('values');
                    $setting->remarks = $request->input('remarks');
                    if ($request->hasFile('images')) {
                        $setting->images = $filename_logo;
                        $setting->values = $filename_logo;
                    }
                    $setting->save();
                    break;
                case 'delete':
                    // DELETE
                    $setting->delete();
                    break;
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
