<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/8/20
 * Time: 15:00
 */

namespace App\Repositories;


use App\Action;
use Illuminate\Support\Facades\Redis;
use Mockery\Exception;

class ActionRepository
{

    public function create(array $attribute)
    {
        $action = Action::create($attribute);
        return $action;
    }

    public function update(array $whereData, array $setData)
    {
        $result = Action::where($whereData)->update($setData);
        return $result;
    }

    public function pullActionToTimeline($userId, $actionId)
    {
        $data = json_encode([
            'user_id' => $userId,
            'action_id' => $actionId
        ]);
        $offset = Redis::rpush(config('constants.action_timeline'), $data);
        return $offset;
    }

    public function getActionItem($userId, $paginate)
    {
        $actions = Action::notUndo()
            ->with([
                'user',
                'actionable' => function ($query) {
                    return $query->with('question');
                }
            ])
            ->latest('updated_at')
            ->where('user_id', $userId)
            ->paginate($paginate);
        return $actions;
    }

}