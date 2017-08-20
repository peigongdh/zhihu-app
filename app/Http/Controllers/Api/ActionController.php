<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ActionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActionController extends Controller
{
    protected $actionRepository;

    /**
     * TimelineController constructor.
     * @param $actionRepository
     */
    public function __construct(ActionRepository $actionRepository)
    {
        // $this->middleware('auth');
        $this->actionRepository = $actionRepository;
    }

    public function index()
    {
        $user = user('api');
        $actions = $this->actionRepository->getActionItem($user->id, 10);
        return $actions;
    }

}
