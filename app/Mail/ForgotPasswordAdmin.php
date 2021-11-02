<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ForgotPasswordAdmin extends Mailable
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
        $title_mail = "Fressh Mama xác minh đăng nhập Admin" . ' ' . $now;

        return $this->view('admin.users.mail.resetPassword', ['token' => $this->token, 'email' => $targetMail])->to($targetMail)->subject($title_mail);
    }
}