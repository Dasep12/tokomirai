<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    //
    public function transactions(Request $request)
    {

        $perPage = $request->get('show', 10);
        $search = $request->get('search');
        $query = Transactions::query();

        $status = $request->get('status');

        if ($status) {
            $query->where('status', $status);
        }

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
        $id = $request->input('transaction_process_id');
        try {
            DB::beginTransaction();
            $transaction = Transactions::find($id);
            $transaction->status = $request->input('crud-process-action');
            DB::table('transactions_status')->insert([
                'transaction_id' => $transaction->id,
                'status_name' => $transaction->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $transaction->save();
            self::sendMail($id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data di proses']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function customers(Request $request)
    {
        $perPage = $request->get('show', 10);
        $search = $request->get('search');
        $query =  DB::table('transactions')
            ->selectRaw('name,email,phone,MAX(created_at) as created_at')
            ->groupBy('name', 'email', 'phone');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }
        $customers = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // AJAX REQUEST
        if ($request->ajax()) {
            return view(
                'admin.customer.partials.table',
                compact('customers')
            )->render();
        }
        return view(
            'admin.customer.index',
            compact('customers')
        );
    }


    public function sendMail($id)
    {
        $transaction = Transactions::find($id);
        Mail::to($transaction->email)->send(new NotificationMail($transaction));
    }
}
