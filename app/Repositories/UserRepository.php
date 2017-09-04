<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/1
 * Time: 18:02
 */

namespace App\Repositories;


use App\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function byId($id)
    {
        return User::find($id);
    }

    public function getNotificationItem($userId, $paginate)
    {
        $notifications = User::find($userId)->notifications;
        $notificationGroups = $notifications->groupBy(function ($item, $key) {
            return substr($item['created_at'], 0, 10);
        });
        $notificationItems = new LengthAwarePaginator($notificationGroups, $notificationGroups->count(), $paginate);
        return $notificationItems;
    }
}