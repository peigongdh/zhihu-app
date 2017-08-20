<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/8/20
 * Time: 16:40
 */

namespace App\Repositories;

use App\Timeline;

class TimelineRepository
{

    public function getTimelineItem($paginate)
    {
        $questions = Timeline::published()->latest('created_at')->with('user')->where('is_hidden', '=', 'F')->paginate($paginate);
        return $questions;
    }

}