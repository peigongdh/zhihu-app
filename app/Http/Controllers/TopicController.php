<?php

namespace App\Http\Controllers;

use App\Repositories\TopicRepository;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    protected $topicRepository;

    /**
     * TopicController constructor.
     * @param $topicRepository
     */
    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    public function index(Request $request)
    {
        return $this->topicRepository->getTopicsForTagging($request);
    }
}
