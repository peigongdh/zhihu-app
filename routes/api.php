<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->get('/topic', 'TopicController@index');
Route::middleware('api')->post('/question/follower', 'QuestionFollowController@follower');
Route::middleware('auth:api')->post('/question/follow', 'QuestionFollowController@followThisQuestion');


Route::middleware('api')->post('/user/followers', 'FollowerController@index');
Route::middleware('api')->post('/user/follow', 'FollowerController@follow');

Route::middleware('api')->post('/answer/vote/users', 'VoteController@users');
Route::middleware('api')->post('/answer/vote', 'VoteController@vote');

Route::middleware('api')->post('/message/store', 'MessageController@store');

Route::get('answer/{id}/comments', 'CommentController@answer');
Route::get('question/{id}/comments', 'CommentController@question');

Route::post('comment', 'CommentController@store');

Route::get('item/question', function() {
    $questionRepository = new \App\Repositories\QuestionRepository();
    $question = $questionRepository->getQuestionsItem(20);
    return $question;
});