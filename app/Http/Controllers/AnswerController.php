<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{

    protected $answerRepository;

    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function store(StoreAnswerRequest $request, $questionId)
    {
        $data = [
            'question_id' => $questionId,
            'user_id' => Auth::id(),
            'body' => $request->get('body')
        ];
        $answer = $this->answerRepository->create($data);
        $answer->question()->increment('answers_count');
        return back();
    }
}
