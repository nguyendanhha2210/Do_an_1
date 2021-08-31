<?php

namespace App\Http\Controllers\Ship\User;

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
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    public function loginForm(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('ship.users.login');
        }

        if ($request->isMethod('post')) {
            $credentials = $request->only('email', 'password');
            $credentials['role_id'] = RoleStateType::SHIP;

            $message = '';
            if (Auth::guard('ship')->attempt($credentials)) {
                return redirect(route('ship.home'));
            } else {
                $message = 'Please check email address and password !';
            }

            return view('ship.users.login', [
                'message' => $message,
                'old_email' => $request->email,
                'old_password' => $request->password,
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('ship')->logout();
        return redirect(route('ship.users.login'));
    }
}
