<?php

use Encore\Admin\Facades\Admin;
use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/zhihu/users', UserController::class);
    $router->resource('/zhihu/questions', QuestionController::class);
    $router->resource('/zhihu/answers', AnswerController::class);
    $router->resource('/zhihu/comments', CommentController::class);
});
