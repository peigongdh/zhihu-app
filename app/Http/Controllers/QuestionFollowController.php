<?php

namespace App\Http\Controllers;

use App\Question;
use App\Repositories\ActionRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Integer;

class QuestionFollowController extends Controller
{

    protected $questionRepository;

    protected $actionRepository;

    /**
     * QuestionFollowController constructor.
     * @param QuestionRepository $questionRepository
     * @param ActionRepository $actionRepository
     */
    public function __construct(QuestionRepository $questionRepository, ActionRepository $actionRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->actionRepository = $actionRepository;
    }

    public function follow($questionId)
    {
        Auth::user()->followThis($questionId);
        return back();
    }

    public function follower(Request $request)
    {
        $questionId = $request->get('question');
        $user = user('api');
        $followed = $user->followed($questionId);
        return response()->json(['followed' => $followed]);
    }

    public function followThisQuestion(Request $request)
    {
        $user = user('api');
        $questionId = $request->get('question');

        $user->followThis($questionId);
        $followed = $user->followed($questionId);

        $question = $this->questionRepository->byId($questionId);
        if ($followed) {
            $question->increment('followers_count');

            $actionData = [
                'event' => config('constants.action_user_follow_question'),
                'user_id' => $user->id,
                'actionable_id' => $question->id,
                'actionable_type' => Question::class,
            ];
            $action = $this->actionRepository->create($actionData);
            $this->actionRepository->pullActionToTimeline($user->id, $action->id);
        } else {
            $question->decrement('followers_count');

            $actionWhereData = [
                'event' => config('constants.action_user_follow_question'),
                'user_id' => $user->id,
                'actionable_id' => $question->id,
                'actionable_type' => Question::class,
            ];
            $actionSetData = [
                'undo' => 'T'
            ];
            $this->actionRepository->update($actionWhereData, $actionSetData);
        }
        return response()->json(['followed' => $followed]);
    }
}
