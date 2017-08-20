<?php

namespace App\Http\Controllers;

use App\Repositories\ActionRepository;
use App\Repositories\AnswerRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    protected $answerRepository;

    protected $actionRepository;

    /**
     * VoteController constructor.
     * @param $answerRepository
     * @param $actionRepository
     */
    public function __construct(AnswerRepository $answerRepository, ActionRepository $actionRepository)
    {
        $this->answerRepository = $answerRepository;
        $this->actionRepository = $actionRepository;
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

            $actionData = [
                'event' => config('constants.action_user_vote_answer'),
                'user_id' => $user->id,
                'post_id' => $answer->id,
            ];
            $action = $this->actionRepository->create($actionData);
            $this->actionRepository->pullActionToTimeline($user->id, $action->id);

            return response()->json(['voted' => true]);
        }
        $answer->decrement('votes_count');
        $user->decrement('likes_count');
        $answer->user()->decrement('favorites_count');

        $actionWhereData = [
            'event' => config('constants.action_user_vote_answer'),
            'user_id' => $user->id,
            'post_id' => $answer->id,
        ];
        $actionSetData = [
            'undo' => 'T'
        ];
        $this->actionRepository->update($actionWhereData, $actionSetData);

        return response()->json(['voted' => false]);
    }
}
