<?php

namespace App\Admin\Controllers;

use App\Answer;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AnswerController extends Controller
{
    use ModelForm;

    private $IS_HIDDEN_SWITCH = [
        'on' => ['value' => 'F', 'text' => '正常', 'color' => 'success'],
        'off' => ['value' => 'T', 'text' => '隐藏', 'color' => 'danger'],
    ];

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Answer::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('body', 'url')->display(function ($body) {
                return "<a href='/question/{$this->question_id}#answer_{$this->id}'>链接</a>";
            });
            $grid->column('user_id');
            $grid->is_hidden()->switch($this->IS_HIDDEN_SWITCH);

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Answer::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->textarea('body')->rows(10);
            $form->text('user_id');
            $form->switch('is_hidden')->states($this->IS_HIDDEN_SWITCH);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
