<?php

namespace App\Http\Controllers\Api;

use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    protected $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->questionRepository = $questionRepository;
    }

    public function index()
    {
        $topicId = request('topic');
        if ($topicId) {
            $questions = $this->questionRepository->getQuestionsItemByTopic($topicId, 25);
            return $questions;
        }
        $questions = $this->questionRepository->getQuestionsItem(25);
        return $questions;
    }
}
