<?php

namespace App\Http\Controllers\Sale\User\Password;

use App\Enums\LimitTimeForgot;
use App\Enums\RoleStateType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\Password\ChangeRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function passwordForm(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('sale.users.password.forgot');
        }

        if ($request->isMethod('post')) {
            $message = '';
            $token = bin2hex(random_bytes(64));
            $time = Carbon::now()->addDays(LimitTimeForgot::TIMEFORGOT);

            $user = User::where('email', $request->email_address)->where('role_id', RoleStateType::SALER)->first();

            if ($user) {
                $user->reset_password_token = $token;
                $user->reset_password_token_expire =  $time;
                $flag = $user->save();

                if ($flag) {
                    Mail::send('sale.users.mail.resetPassword', ['token' => $token, 'email' => $request->email_address], function ($message) use ($request) {
                        $message->to($request->email_address);
                    });
                    return redirect('sale/forgot-password-complete');
                }
            } else {
                $message = 'Email does not exist.';
            }

            return view('sale.users.password.forgot', [
                'message' => $message,
                'old_email' => $request->email_address
            ]);
        }
    }

    public function forgotPasswordComplete(Request $request)
    {
        return view('sale.users.password.successmail');
    }

    public function getToken(Request $request)
    {
        $email = explode("/", url()->current())[5];
        $tokenUrl = explode("/", url()->current())[6];

        $message = '';
        $user = User::where('email', $email)->first();
        if (!$user) {
            $message = 'Email not found!';
        } elseif ($user->reset_password_token != $tokenUrl) {
            $message = 'Token not found。';
        } elseif (Carbon::parse($user->reset_password_token_expire)->lessThanOrEqualTo(Carbon::now())) {
            $message = 'The token has expired.';
        }
        return view('sale.users.password.change', [
            'tokenUrl' => $tokenUrl,
            'message' => $message,
        ]);
    }

    public function resetPassword(ChangeRequest $request)
    {
        $message2 = '';
        $user = User::where('reset_password_token', $request->reset_password_token)->whereDate('reset_password_token_expire', '>', Carbon::now())->first();
        if ($user) {
            $user->password = Hash::make($request->password_confirm);
            $flag = $user->save();
            if ($flag) {
                return redirect('/sale/change-password-complete');
            } else {
                $message2 = 'Thay đổi thất bại !';
            }
        } else {
            $message2 = 'Mã thông báo đã hết hạn !';
        }
        return view('sale.users.password.forgot', [
            'message2' => $message2,
        ]);
    }

    public function changePasswordComplete()
    {
        return view('sale.users.password.success');
    }
}
