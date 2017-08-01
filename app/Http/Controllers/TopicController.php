<?php

namespace App\Http\Controllers;

use App\Repositories\TopicRepository;
use Illuminate\Http\Request;

/**
 * Class TopicController
 * @package App\Http\Controllers
 */
class TopicController extends Controller
{
    /**
     * @var TopicRepository
     */
    protected $topicRepository;


    /**
     * TopicController constructor.
     * @param TopicRepository $topicRepository
     */
    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Request $request)
    {
        return $this->topicRepository->getTopicsForTagging($request);
    }

    /**
     * @param $topic
     * @return mixed
     */
    public function topicQuestion($topic)
    {
        return view('question.index', compact('topic'));
    }
}
