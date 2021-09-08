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
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password_confirm);
            $user->role_id = RoleStateType::SALER;
            $flag = $user->save();
            if ($flag) {
                $message = 'Đăng kí thành công !';
            } else {
                $message = 'Đăng kí thất bại !';
            }
            return view('sale.users.login', [
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
}
