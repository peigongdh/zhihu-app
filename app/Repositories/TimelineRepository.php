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

    public function getTimelineItem($userId, $paginate)
    {
        $questions = Timeline::latest('created_at')
            ->with([
                'action' => function ($query) {
                    return $query
                        ->notUndo()
                        ->with([
                            'user',
                            'actionable' => function ($query) {
                                return $query->with('question');
                            }
                        ]);
                }
            ])
            ->where('user_id', $userId)
            ->paginate($paginate);
        return $questions;
    }

}