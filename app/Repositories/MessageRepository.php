<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/8
 * Time: 16:18
 */

namespace App\Repositories;


use App\Message;

class MessageRepository
{

    public function create(array $attributes)
    {
        return Message::create($attributes);
    }

    public function getAllMessages($userId)
    {
        return Message::where('to_user_id', $userId)
            ->orWhere('from_user_id', $userId)
            ->with([
                'fromUser' => function ($query) {
                    return $query->select(['id', 'name', 'avatar']);
                },
                'toUser' => function ($query) {
                    return $query->select(['id', 'name', 'avatar']);
                },
            ])
            ->latest()
            ->get();
    }

    public function getDialogMessageByDialogId($dialogId)
    {
        return Message::where('dialog_id', $dialogId)
            ->with([
                'fromUser' => function ($query) {
                    return $query->select(['id', 'name', 'avatar']);
                },
                'toUser' => function ($query) {
                    return $query->select(['id', 'name', 'avatar']);
                },
            ])
            ->latest()
            ->get();
    }

    public function getSingleMessageByDialogId($dialogId)
    {
        return Message::where('dialog_id', $dialogId)->first();
    }

    public function getMessageItem($userId, $paginate)
    {
        $dialogIds = Message::select('dialog_id')
            ->distinct()
            ->paginate($paginate);
        return Message::where('to_user_id', $userId)
            ->orWhere('from_user_id', $userId)
            ->whereIn('dialog_id', $dialogIds->getCollection()->toArray())
            ->with([
                'fromUser' => function ($query) {
                    return $query->select(['id', 'name', 'avatar']);
                },
                'toUser' => function ($query) {
                    return $query->select(['id', 'name', 'avatar']);
                },
            ])
            ->latest()
            ->paginate($paginate);
    }
}
