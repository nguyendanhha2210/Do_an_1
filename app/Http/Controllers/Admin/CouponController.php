<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleStateType;
use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

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
            $coupon->status = StatusSale::DOWN;
            $coupon->number = $request->number;
            $coupon->code = $request->code;
            $coupon->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
            $coupon->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
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
            $coupon->status = StatusSale::DOWN;
            $coupon->number = $request->number;
            $coupon->code = $request->code;
            $coupon->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
            $coupon->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
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

    public function sendCustomer($id)
    {
        // $message = '';
        // $token = bin2hex(random_bytes(64));
        // $time = Carbon::now()->addDays(LimitTimeForgot::TIMEFORGOT);

        // $user = User::where('email', $request->email_address)->where('role_id', RoleStateType::MANAGERMENT)->first();

        // if ($user) {
        //     $user->reset_password_token = $token;
        //     $user->reset_password_token_expire =  $time;
        //     $flag = $user->save();

        //     if ($flag) {
        //         Mail::send('admin.users.mail.resetPassword', ['token' => $token, 'email' => $request->email_address], function ($message) use ($request) {
        //             $message->to($request->email_address);
        //         });
        //         return redirect('admin/forgot-password-complete');
        //     }
        // } else {
        //     $message = 'Email does not exist.';
        // }

        // return view('admin.users.password.forgot', [
        //     'message' => $message,
        //     'old_email' => $request->email_address
        // ]);

        $customer = User::where('role_id', '=', RoleStateType::SALER)->get();

        $coupon = Coupon::where('id', $id)->first();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

        $title_mail = "Mã khuyến mãi ngày" . ' ' . $now;

        $data = [];
        foreach ($customer as $normal) {
            $data['email'][] = $normal->email;
        }

        $coupon = array(
            'start_date' => $coupon->start_date,
            'end_date' => $coupon->end_date,
            'time' => $coupon->time,
            'condition' => $coupon->condition,
            'number' => $coupon->number,
            'code' => $coupon->code
        );

        if ($data && $coupon) {
            Mail::send('admin.users.mail.sendCoupon',  ['coupon' => $coupon], function ($message) use ($title_mail, $data) {
                $message->to($data['email'])->subject($title_mail); //send this mail with subject
                $message->from($data['email'], $title_mail); //send from this mail
            });

            return redirect()->back()->with('message', 'Gửi mã khuyến mãi khách hàng thành công !');
        } else {
            return redirect()->back()->with('message', 'Gửi mã khuyến mãi khách hàng thất bại !');
        }
    }
}
