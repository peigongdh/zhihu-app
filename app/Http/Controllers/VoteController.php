<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
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
        $voted = user('api')->voteFor($answerId);

        if (count($voted['attached']) > 0) {
            $answer->increment('votes_count');
            return response()->json(['voted' => true]);
        }
        $answer->decrement('votes_count');
        return response()->json(['voted' => false]);
    }
}
