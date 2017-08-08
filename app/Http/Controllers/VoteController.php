<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    protected $answerRepository;

    /**
     * VoteController constructor.
     * @param $answerRepository
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function users()
    {
        $answerId = request()->get('answer');
        $user = user('api');
        return response()->json(['voted' => $user->hasVotedFor($answerId)]);
    }

    public function vote()
    {
        $answerId = request()->get('answer');
        $answer = $this->answerRepository->byId($answerId);
        $user = user('api');
        $voted = $user->voteFor($answerId);

        if (count($voted['attached']) > 0) {
            $answer->increment('votes_count');
            $user->increment('likes_count');
            $answer->user()->increment('favorites_count');
            return response()->json(['voted' => true]);
        }
        $answer->decrement('votes_count');
        $user->decrement('likes_count');
        $answer->user()->decrement('favorites_count');
        return response()->json(['voted' => false]);
    }
}
