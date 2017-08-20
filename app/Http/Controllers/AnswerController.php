<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\ActionRepository;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;

class AnswerController extends Controller
{

    protected $answerRepository;

    protected $actionRepository;

    public function __construct(AnswerRepository $answerRepository, ActionRepository $actionRepository)
    {
        $this->answerRepository = $answerRepository;
        $this->actionRepository = $actionRepository;
    }

    public function store(StoreAnswerRequest $request, $questionId)
    {
        $user = user();
        $answerData = [
            'question_id' => $questionId,
            'user_id' => $user->id,
            'body' => $request->get('body')
        ];
        $answer = $this->answerRepository->create($answerData);
        $answer->question()->increment('answers_count');
        $user->increment('answers_count');

        $actionData = [
            'event' => config('constants.action_user_new_answer'),
            'user_id' => $user->id,
            'actionable_id' => $answer->id,
            'actionable_type' => Answer::class,
        ];
        $action = $this->actionRepository->create($actionData);
        $this->actionRepository->pullActionToTimeline($user->id, $action->id);

        return back();
    }
}
