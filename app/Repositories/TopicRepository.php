<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/12
 * Time: 22:16
 */

namespace App\Repositories;


use App\Topic;
use Illuminate\Http\Request;


class TopicRepository
{

    public function getTopicsForTagging(Request $request)
    {
        $topics = Topic::select(['id', 'name'])->where('name', 'like', '%' . $request->query('q') . '%')->get();
        return $topics;
    }

}