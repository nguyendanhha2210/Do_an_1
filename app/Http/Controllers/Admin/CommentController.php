<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Comment List'];
            return view('admin.comments.index', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getData(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $paginate = $request->paginate;
            $comments = Comment::orderBy('created_at', 'desc')->paginate($paginate);

            return response()->json($comments, StatusCode::OK);
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
