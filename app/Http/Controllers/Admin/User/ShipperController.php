<?php

namespace App\Http\Controllers\Admin\User;

use App\Enums\LimitTimeForgot;
use App\Enums\OrderStatus;
use App\Enums\RoleStateType;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ShipperController extends Controller
{
    public function indexShip()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Shipper List'];
            return view('admin.users.shipper', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getShipper(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $ships = User::where('role_id', '=', RoleStateType::SHIP)->where(function ($q) use ($search) {
                if ($search) {
                    $q->where('email', 'like', '%' . $search . '%');
                }
            })->orderBy('created_at', 'desc')->paginate($paginate);
            return response()->json($ships, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        try {
            $ship = new User();
            $ship->name = $request->name;
            $ship->email  = $request->email;
            $ship->role_id  = RoleStateType::SHIP;
            $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $ship->email_verified_at  = $today;
            $ship->password  =  bcrypt($request->password);
            $ship->reset_password_token  = "";
            $ship->reset_password_token_expire  = $today;
            $ship->remember_token  = "";
            $flagship = $ship->save();
            if ($flagship) {
                return response()->json(StatusCode::OK);  //Lưu thành công gọi ra đg dẫn về list
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $ship = User::where('id', $id)->firstOrFail();
            $ship->name = $request->name;
            $ship->email  = $request->email;
            $ship->role_id  = RoleStateType::SHIP;
            $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $ship->email_verified_at  = $today;
            $ship->password  =  bcrypt($request->password);
            $ship->reset_password_token  = "";
            $ship->reset_password_token_expire  = $today;
            $ship->remember_token  = "";
            $ship->save();
            return response()->json(StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function destroy($id)
    {
        $ship = User::find($id);
        $ship->delete();
    }
}
