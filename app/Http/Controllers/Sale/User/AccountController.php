<?php

namespace App\Http\Controllers\Sale\User;

use App\Enums\LimitTimeForgot;
use App\Enums\RoleStateType;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    public function loginForm(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('sale.users.login');
        }

        if ($request->isMethod('post')) {
            $credentials = $request->only('email', 'password');
            $credentials['role_id'] = RoleStateType::SALER;

            $message = '';
            if (Auth::guard('sales')->attempt($credentials)) {
                if (Session::get('cart') == true) {
                    return redirect(route('admin.cart.viewCart'));
                } else {
                    return redirect(route('sale.index'));
                }
            } else {
                $message = 'Please check email address and password !';
            }

            return view('sale.users.login', [
                'message' => $message,
                'old_email' => $request->email,
                'old_password' => $request->password,
            ]);
        }
    }

    public function registerForm(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('sale.users.register');
        }
        if ($request->isMethod('post')) {
            $userEmail = User::where('role_id', '=', RoleStateType::SALER)->get();
            $count = 0;
            foreach ($userEmail as $key => $email) {
                if ($request->email == $email->email) {
                    $count = 1;
                }
            }

            if ($count == 1) {
                $message = 'Email Đã Tồn Tại, Vui Lòng Nhập Lại !';
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->phone = $request->phone;
                $user->email = $request->email;
                $user->images = '';
                $user->password = bcrypt($request->password_confirm);
                $user->role_id = RoleStateType::CLIENT;
                $flag = $user->save();
                if ($flag) {
                    $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
                    $title_mail = "Fressh Mama xác minh đăng kí" . ' ' . $now;

                    Mail::send('sale.users.mail.confirmRegister', ['email' => $request->email], function ($message) use ($title_mail, $request) {
                        $message->to($request->email)->subject($title_mail);
                    });
                    $message = 'Đăng kí thành công, Vui Lòng Vào Email Để Xác Nhận Trước Khi Đăng Nhập !';
                } else {
                    $message = 'Đăng kí thất bại !';
                }
                return view('sale.users.login', [
                    'message' => $message,
                ]);
            }
            return view('sale.users.register', [
                'message' => $message,
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('sales')->logout();
        Session::flush();
        return redirect(route('sale.index'));
    }

    public function registerConfirm()
    {
        $email = explode("/", url()->current())[4];
        $message = '';
        $user = User::where('email', $email)->where('role_id', '=', RoleStateType::CLIENT)->first();
        if ($user) {
            $user->role_id = RoleStateType::SALER;
            $user->save();
            $message = 'Xác Nhận Thành Công !';
        } else {
            $message = 'Email not found。';
        }

        return view('sale.users.login', [
            'message' => $message,
        ]);
    }
}
