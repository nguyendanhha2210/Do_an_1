<?php

namespace App\Http\Controllers\Sale;

use App\Enums\RoleStateType;
use App\Enums\StatusCode;
use App\Enums\StatusCoupon;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\User;
use App\Models\UserCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        }
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => route('sale.index')

            ], 'My Coupon'
        ];
        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->get();
        return view("sale.coupon.index", ['breadcrumbs' => $breadcrumbs, 'today' => $today], compact('type'));
    }

    public function getCoupon()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        }

        try {
            $id = Auth::guard('sales')->id();
            $coupon = UserCoupon::where('user_id', '=', $id)->where('statusUse', StatusCoupon::SAVE)
                ->with('coupon')->orderBy('created_at', 'DESC')->get();
            return response()->json($coupon, StatusCode::OK);
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
            $userOld = User::find($request->id);
            $userEmail = User::where('role_id', '=', RoleStateType::SALER)->where('email', '!=', $userOld->email)->get();

            $count = 0;
            foreach ($userEmail as $key => $email) {
                if ($request->email == $email->email) {
                    $count = 1;
                }
            }
            if ($count == 1) {
                $message = 'Email Đã Tồn Tại, Vui Lòng Nhập Lại !';
                return response()->json(["error" => $message], StatusCode::OK);
            } else {
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email  = $request->email;
                $user->phone  = $request->phone;
                $file = $request->images;
                if ($file != null) {
                    $fileName = $file->getClientOriginalName();
                    $file->move('uploads/users/', $fileName);
                    $user->images = $fileName;
                } else {
                    $user->images = "avata-3.jpg";
                }
                $user->save();
                return response()->json(["result" => route('sale.profile.index')], StatusCode::OK);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }
}
