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
        $userId = request('user');
        $body = request('body');
        $message = $this->messageRepository->create([
            'to_user_id' => $userId,
            'from_user_id' => user('api')->id,
            'body' => $body,
            'dialog_id' => time() . Auth::id()
        ]);

        return response()->json(['status' => !!$message]);
    }
}
