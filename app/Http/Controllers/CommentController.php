<?php

namespace App\Http\Controllers;

use App\Question;
use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CommentController
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{
    /**
     * @var AnswerRepository
     */
    protected $answerRepository;

    /**
     * @var QuestionRepository
     */
    protected $questionRepository;

    /**
     * @var CommentRepository
     */
    protected $commentRepository;

    /**
     * CommentController constructor.
     * @param $answerRepository
     * @param $questionRepository
     * @param $commentRepository
     */
    public function __construct(AnswerRepository $answerRepository, QuestionRepository $questionRepository, CommentRepository $commentRepository)
    {
        $this->answerRepository = $answerRepository;
        $this->questionRepository = $questionRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function answer($id)
    {
        return $this->answerRepository->getAnswerCommentsById($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function question($id)
    {
        return $this->questionRepository->getQuestionCommentsById($id);
    }

    /**
     * @return mixed
     */
    public function store()
    {
        $id = request('model');
        $type = request('type');
        $body = request('body');
        $model = $this->getModelNameFromType($type);
        $user = user('api');
        $comment = $this->commentRepository->create([
            'commentable_id' => $id,
            'commentable_type' => $model,
            'user_id' => $user->id,
            'body' => $body
        ]);
        $model::find($id)->increment('comments_count');
        $user->increment('comments_count');
        return $comment;
    }

    /**
     * @param $type
     * @return string
     */
    public function getModelNameFromType($type)
    {
        return $type == 'answer' ? 'App\Answer' : 'App\Question';
    }
}
