<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\Concerns\Has;

class UsersController extends Controller
{
    public function user(Request $request)
    {
        $perPage = $request->get('show', 10);
        $search = $request->get('search');
        $query = User::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        $users = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // AJAX REQUEST
        if ($request->ajax()) {
            return view(
                'admin.users.partials.table',
                compact('users')
            )->render();
        }
        return view(
            'admin.users.index',
            compact('users')
        );
    }

    public function crud(Request $request)
    {
        $id = $request->input('id');
        $action = $request->input('crud-action');
        $user = User::find($id);
        try {

            DB::beginTransaction();
            switch ($action) {
                case  "create":
                    User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'provider' => 'LOCAL',
                        'phone' => $request->phone,
                        'status' => $request->status,
                        'is_admin'  => $request->is_admin == "on" ? 1 : 0
                    ]);
                    break;
                case "updated_pwd":
                    $user->password = Hash::make($request->password);
                    $user->save();
                    break;
                case "update":
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->phone = $request->phone;
                    $user->status = $request->status;
                    $user->is_admin  = $request->is_admin == "on" ? 1 : 0;
                    $user->save();
                    break;

                case "delete":
                    $user->delete();
                    break;
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data Berhasil di Perbarui']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);
        return response()->json(['user' => $user]);
    }
}
