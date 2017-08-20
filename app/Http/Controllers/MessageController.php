<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $messageRepository;

    /**
     * MessageController constructor.
     * @param $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function store()
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

        return response()->json(['status' => !!$message]);
    }
}
