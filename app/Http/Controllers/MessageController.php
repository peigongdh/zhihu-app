<?php

namespace App\Http\Controllers;

use App\Notifications\MessageNotification;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageRepository;

    /**
     * MessageController constructor.
     * @param $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->middleware('auth');
        $this->messageRepository = $messageRepository;
    }

    public function index()
    {
        $messages = $this->messageRepository->getAllMessages();
        return view('inbox.index', ['messages' => $messages->groupBy('dialog_id')]);
    }

    public function show($dialogId)
    {
        $messages = $this->messageRepository->getDialogMessageByDialogId($dialogId);
        $messages->markAsRead();
        return view('inbox.show', compact('messages', 'dialogId'));
    }

    public function create()
    {
        $user = user('api');
        $toUserId = request('user');
        $body = request('body');
        $message = $this->messageRepository->create([
            'to_user_id' => $toUserId,
            'from_user_id' => $user->id,
            'body' => $body,
            'dialog_id' => time() . $user->id
        ]);
        // 后续考虑取消该通知，由私信处理
        $message->toUser->notify(new MessageNotification($message));
        return response()->json(['status' => !!$message]);
    }

    public function reply($dialogId)
    {
        $message = $this->messageRepository->getSingleMessageByDialogId($dialogId);
        $toUserId = $message->from_user_id == user()->id ? $message->to_user_id : $message->from_user_id;
        $newMessage = $this->messageRepository->create([
            'from_user_id' => user()->id,
            'to_user_id' => $toUserId,
            'body' => request('body'),
            'dialog_id' => $dialogId
        ]);
        // 后续考虑取消该通知，由私信处理
        $newMessage->toUser->notify(new MessageNotification($newMessage));
        return back();
    }
}
