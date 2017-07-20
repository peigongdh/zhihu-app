<?php

namespace App\Http\Controllers;

use App\Notifications\MessageNotification;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class InboxController extends Controller
{

    protected $messageRepository;

    /**
     * InboxController constructor.
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

    public function store($dialogId)
    {
        $message = $this->messageRepository->getSingleMessageByDialogId($dialogId);
        $toUserId = $message->from_user_id == user()->id ? $message->to_user_id : $message->from_user_id;
        $newMessage = $this->messageRepository->create([
            'from_user_id' => user()->id,
            'to_user_id' => $toUserId,
            'body' => request('body'),
            'dialog_id' => $dialogId
        ]);
        $newMessage->toUser->notify(new MessageNotification($newMessage));
        return back();
    }

}
