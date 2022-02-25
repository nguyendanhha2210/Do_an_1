<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ForgotPasswordUser extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        $targetMail = $this->email;
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "AE Shop xác minh đăng nhập" . ' ' . $now;

        return $this->view('sale.users.mail.resetPassword', ['token' => $this->token, 'email' => $targetMail])->to($targetMail)->subject($title_mail);
    }
}
