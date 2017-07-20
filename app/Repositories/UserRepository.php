<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/1
 * Time: 18:02
 */

namespace App\Repositories;


use App\User;

class UserRepository
{
    public function byId($id)
    {
        return User::find($id);
    }

}