<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/12
 * Time: 21:57
 */

namespace App\Repositories;


use App\Comment;

class CommentRepository
{

    public function create(array $attribute)
    {
        $answer = Comment::create($attribute);
        return $answer;
    }

}