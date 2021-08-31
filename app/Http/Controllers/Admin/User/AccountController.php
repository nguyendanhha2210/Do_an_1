<?php

namespace App\Http\Controllers\Admin\User;

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
            return view('admin.users.login');
        }

        if ($request->isMethod('post')) {
            $credentials = $request->only('email', 'password');
            $credentials['role_id'] = RoleStateType::MANAGERMENT;

            $message = '';
            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect(route('admin.home'));
            } else {
                $message = 'Please check email address and password !';
            }

            return view('admin.users.login', [
                'message' => $message,
                'old_email' => $request->email,
                'old_password' => $request->password,
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('admin.users.login'));
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $flag = $user->save();
            if ($flag) {
                return response()->json($user, StatusCode::CREATED);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::UNAUTHORIZED);
        }
    }
}
