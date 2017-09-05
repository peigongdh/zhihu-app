<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/9/4
 * Time: 22:54
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class NotificationController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth:api');
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $user = user('api');
        $notifications = $this->userRepository->getNotificationItem($user->id, 10, request('page'));
        return $notifications;
    }

}