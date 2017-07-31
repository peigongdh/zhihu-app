<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/6/24
 * Time: 18:39
 */

namespace App\Repositories;


use App\Answer;

class AnswerRepository
{

    public function create(array $attribute)
    {
        $answer = Answer::create($attribute);
        return $answer;
    }

    public function byId($answerId)
    {
        return Answer::find($answerId);
    }

    public function getAnswerCommentsById($id)
    {
        $answer = Answer::with('comments', 'comments.user')->where('id', $id)->first();
        return $answer->comments;
    }

    public function getAnswersItem($questionId, $paginate) {
        $questions = Answer::with('comments', 'comments.user')->with('user')->where('question_id', '=', $questionId)->paginate($paginate);
        return $questions;
    }

}