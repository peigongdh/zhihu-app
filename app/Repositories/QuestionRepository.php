<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/6/21
 * Time: 1:04
 */

namespace App\Repositories;


use App\Question;
use App\Topic;

class QuestionRepository
{
    public function byIdWithTopicsAndAnswers($id)
    {
        $question = Question::published()
            ->with(['topics', 'answers'])
            ->findOrFail($id);
        return $question;
    }

    public function create(array $attribute)
    {
        $question = Question::create($attribute);
        return $question;
    }

    public function byId($id)
    {
        $question = Question::published()
            ->findOrFail($id);
        return $question;
    }

    public function getQuestionsFeed()
    {
        $questions = Question::published()
            ->latest('updated_at')
            ->with('user')
            ->get();
        return $questions;
    }

    public function getQuestionsItem($paginate)
    {
        $questions = Question::published()
            ->latest('updated_at')
            ->with('user')
            ->paginate($paginate);
        return $questions;
    }

    public function getQuestionsItemByTopic($topicId, $paginate)
    {
        $questions = Question::published()
            ->with('user')
            ->leftJoin('question_topic', 'questions.id', '=', 'question_topic.question_id')
            ->where('question_topic.topic_id', '=', $topicId)
            ->latest('questions.updated_at')
            ->paginate($paginate);
        return $questions;
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic) {
            if (is_numeric($topic)) {
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }
            $newTopic = Topic::create(['name' => $topic, 'bio' => '', 'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }

    public function getQuestionCommentsById($id)
    {
        $question = Question::published()
            ->with('comments', 'comments.user')
            ->where('id', $id)
            ->first();
        if ($question) {
            return $question->comments;
        }
        return null;
    }

}