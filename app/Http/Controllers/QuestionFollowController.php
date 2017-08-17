<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionFollowController extends Controller
{

    protected $questionRepository;

    /**
     * QuestionFollowController constructor.
     * @param QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
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

    public function followThisQuestion(Request $request) {
        $user = user('api');
        $questionId = $request->get('question');

        $user->followThis($questionId);
        $followed = $user->followed($questionId);

        $question = $this->questionRepository->byId($questionId);
        if ($followed) {
            $question->increment('followers_count');
        } else {
            $question->decrement('followers_count');
        }

        $this->questionRepository->pullUserFollowQuestionToTimeline($questionId);
        return response()->json(['followed' => $followed]);
    }
}
