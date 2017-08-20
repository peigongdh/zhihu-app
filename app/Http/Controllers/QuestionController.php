<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Question;
use App\Repositories\ActionRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Mockery\Exception;

class QuestionController extends Controller
{

    protected $questionRepository;

    protected $actionRepository;

    public function __construct(QuestionRepository $questionRepository, ActionRepository $actionRepository)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->questionRepository = $questionRepository;
        $this->actionRepository = $actionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('question.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question.make');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreQuestionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $user = user();
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        $questionData = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => $user->id,
        ];
        $question = $this->questionRepository->create($questionData);
        $question->topics()->attach($topics);
        $user->increment('questions_count');

        $actionData = [
            'event' => config('constants.action_user_new_question'),
            'user_id' => $user->id,
            'actionable_id' => $question->id,
            'actionable_type' => Question::class,
        ];
        $action = $this->actionRepository->create($actionData);
        $this->actionRepository->pullActionToTimeline($user->id, $action->id);

        return redirect()->route('question.show', [$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);
        return view('question.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);
        if (Auth::user()->owns($question)) {
            return view('question.edit', compact('question'));
        }
        return back();
    }

    /**
     * @param StoreQuestionRequest $request
     * @param $id
     * @return mixed
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $question = $this->questionRepository->byId($id);
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ];
        $question->update($data);

        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        $question->topics()->sync($topics);
        return redirect()->route('question.show', [$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);
        if (Auth::user()->owns($question)) {
            $question->delete();
            return redirect('/');
        }
        abort(403, 'Forbidden');
    }

}
