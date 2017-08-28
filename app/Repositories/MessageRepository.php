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

    public function getAllMessages()
    {
        return Message::where('to_user_id', user()->id)
            ->orWhere('from_user_id', user()->id)
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

    public function getMessageItem($userId, $paginate)
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
            ->paginate($paginate);
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
}