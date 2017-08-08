<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $user)
    {
        $this->userRepository = $user;
    }

    public function index(Request $request)
    {
        $user = $this->userRepository->byId($request->get('user'));
        $followers = $user->followersUser()->pluck('follower_id')->toArray();
        if (in_array(user('api')->id, $followers)) {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function follow(Request $request)
    {
        $user = user('api');
        // 禁止自己关注自己
        if ($user->id == $request->get('user')) {
            return response()->json(['followed' => false]);
        }
        $userToFollow = $this->userRepository->byId($request->get('user'));
        $followed = $user->followThisUser($userToFollow->id);

        if (count($followed['attached']) > 0) {
            $userToFollow->notify(new NewUserFollowNotification());
            $userToFollow->increment('followers_count');
            $user->increment('followings_count');
            return response()->json(['followed' => true]);
        }
        $userToFollow->decrement('followers_count');
        $user->decrement('followings_count');
        return response()->json(['followed' => false]);
    }
}
