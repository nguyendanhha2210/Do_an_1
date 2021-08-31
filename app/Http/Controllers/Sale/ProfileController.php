<?php

namespace App\Http\Controllers\Sale;

use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        }
        $breadcrumbs = ['Profile'];
        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->get();
        return view("sale.profile.index", ['breadcrumbs' => $breadcrumbs], compact('type'));
    }

    public function getUser()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        }

        try {
            $id = Auth::guard('sales')->id();
            $user = User::where('id', '=', $id)->get();
            return response()->json($user, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function updateUser(Request $request)
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        }
        try {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email  = $request->email;
            $user->save();
            return response()->json(route('sale.profile.index'), StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }
}
