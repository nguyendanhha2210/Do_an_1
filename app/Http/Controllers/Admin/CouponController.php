<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Coupon List'];
            return view('admin.coupons.index', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getData(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $coupons = Coupon::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                }
            })->orderBy('created_at', 'desc')->paginate($paginate);

            return response()->json($coupons, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function create()
    {
        $breadcrumbs = ['Add New Coupon'];
        return view('admin.coupons.add', ['breadcrumbs' => $breadcrumbs]);
    }

    public function store(CouponRequest $request)
    {
        try {
            $coupon = new coupon();
            $coupon->name = $request->name;
            $coupon->time = $request->time;
            $coupon->condition = $request->condition;
            $coupon->number = $request->number;
            $coupon->code = $request->code;
            $flag = $coupon->save();
            if ($flag) {
                return response()->json(route('admin.coupon.list'), StatusCode::OK);  //Lưu thành công gọi ra đg dẫn về list
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        $breadcrumbs = ['Edit coupon'];
        return view('admin.coupons.edit', compact('coupon'), ['breadcrumbs' => $breadcrumbs]);
    }

    public function update(CouponRequest $request, $id)
    {
        try {
            $coupon = Coupon::find($id);
            $coupon->name = $request->name;
            $coupon->time = $request->time;
            $coupon->condition = $request->condition;
            $coupon->number = $request->number;
            $coupon->code = $request->code;
            $coupon->save();
            return response()->json(route('admin.coupon.list'), StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }

    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();
    }
}
