<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/8
 * Time: 16:18
 */

namespace App\Repositories;


use App\Message;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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

    public function getMessageItem($userId, $paginate, $currentPage)
    {
        $rows = Message::select(DB::raw('dialog_id, max(created_at) as created_at'))
            ->where(function ($query) use ($userId) {
                $query->where('to_user_id', $userId)
                    ->orWhere('from_user_id', $userId);
            })
            ->groupBy('dialog_id')
            ->orderBy('created_at', 'desc')
            ->get();
        $dialogIds = array_column($rows->toArray(), 'dialog_id');
        $cutDialogIds = array_slice($dialogIds, ($currentPage - 1) * $paginate, $paginate);
        $messages = Message::whereIn('dialog_id', $cutDialogIds)
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
        $messageGroups = $messages->groupBy('dialog_id')->sortByDesc(function($groups, $dialogId) {
            return $groups[0]['created_at'];
        });
        $messageItems = new LengthAwarePaginator($messageGroups, count($dialogIds), $paginate, $currentPage);
        return $messageItems;
    }
}
