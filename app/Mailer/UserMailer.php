<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/2
 * Time: 19:28
 */

namespace App\Mailer;


use App\User;
use Illuminate\Support\Facades\Auth;

class UserMailer extends Mailer
{
    public function followNotify($email)
    {
        $data = [
            'url' => url(config('app.url')),
            'name' => user('api')->name
        ];
        $this->sendTo('zhihu_app_new_user_follow', $email, $data);
    }

    public function passwordReset($email, $token)
    {
        $data = [
            'url' => url(config('app.url') . route('password.reset', $token, false))
        ];
        $this->sendTo('zhihu_app_password_reset', $email, $data);
    }

    public function registerVerify(User $user)
    {
        $data = [
            'url' => route('email.verify', ['token' => $user->confirmation_token]),
            'name' => $user->name,
        ];
        $this->sendTo('zhihu_app_register', $user->email, $data);
    }
}