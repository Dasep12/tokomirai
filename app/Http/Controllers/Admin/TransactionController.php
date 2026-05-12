<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //
    public function transactions(Request $request)
    {
        $perPage = $request->get('show', 10);
        $search = $request->get('search');
        $query = Transactions::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('invoice', 'LIKE', "%{$search}%");
            });
        }
        $transactions = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // AJAX REQUEST
        if ($request->ajax()) {
            return view(
                'admin.transaction.partials.table',
                compact('transactions')
            )->render();
        }
        return view(
            'admin.transaction.index',
            compact('transactions')
        );
    }

    public function detail(Request $request)
    {
        $id = $request->input('id');
        $transaction = Transactions::find($id);
        return response()->json(['transaction' => $transaction]);
    }

    public function crud(Request $request)
    {
        $id = $request->input('id');
        try {
            DB::beginTransaction();
            $transaction = Transactions::find($id);
            switch ($request->input('crud-action')) {
                case 'update':
                    // UPDATE
                    break;
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function customers(Request $request)
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
}
