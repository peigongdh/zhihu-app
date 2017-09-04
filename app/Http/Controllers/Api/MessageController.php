<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->middleware('auth:api');
        $this->messageRepository = $messageRepository;
    }

    public function index()
    {
        $user = user('api');
        $messages = $this->messageRepository->getMessageItem($user->id, 10);
        return $messages;
    }

}
