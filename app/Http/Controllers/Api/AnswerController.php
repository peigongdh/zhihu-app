<?php

namespace App\Http\Controllers\Api;

use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnswerController extends Controller
{
    protected $answerRepository;

    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function index($questionId)
    {
        $answer = $this->answerRepository->getAnswersItem($questionId, 5);
        return $answer;
    }
}
