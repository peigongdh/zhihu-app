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

    public function byId($id)
    {

        return Answer::published()->findOrFail($id);
    }

    public function getAnswerCommentsById($id)
    {
        $answer = Answer::published()
            ->with('comments', 'comments.user')
            ->where('id', $id)
            ->first();
        if ($answer) {
            return $answer->comments;
        }
        return null;
    }

    public function getAnswersItem($questionId, $paginate)
    {
        $answers = Answer::published()
            ->with('comments', 'comments.user')
            ->with('user')
            ->where('question_id', '=', $questionId)
            ->paginate($paginate);
        return $answers;
    }

}