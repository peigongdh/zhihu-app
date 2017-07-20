<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/16
 * Time: 14:24
 */

namespace App;


use Illuminate\Database\Eloquent\Collection;

class MessageCollection extends Collection
{

    public function markAsRead()
    {
        $this->each(function(Message $message) {
            if ($message->to_user_id == user()->id) {
                $message->markAsRead();
            }
        });
    }
}
