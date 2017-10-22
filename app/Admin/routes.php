<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/zhihu/users', UserController::class);
    $router->resource('/zhihu/questions', QuestionController::class);
    $router->resource('/zhihu/answers', AnswerController::class);
    $router->resource('/zhihu/comments', CommentController::class);
});
