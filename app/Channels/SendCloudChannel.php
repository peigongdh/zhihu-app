<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/2
 * Time: 18:57
 */

namespace App\Channels;


use App\Notifications\NewUserFollowNotification;
use Illuminate\Support\Facades\Notification;

class SendCloudChannel
{
    public function send($notifiable, NewUserFollowNotification $notification)
    {
        $message = $notification->toSendCloud($notifiable);
    }
}