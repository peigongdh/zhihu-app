<?php

namespace App\Admin\Controllers;

use App\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserController extends Controller
{
    use ModelForm;

    private $IS_ACTIVE_SWITCH = [
        'on' => ['value' => 1, 'text' => '已激活', 'color' => 'success'],
        'off' => ['value' => 0, 'text' => '未激活', 'color' => 'danger'],
    ];

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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->avatar()->image('', 48, 48);
            $grid->column('name');
            $grid->column('email')->editable();

            $grid->is_active()->switch($this->IS_ACTIVE_SWITCH);
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
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('name');
            $form->email('email');

            $form->switch('is_active')->states($this->IS_ACTIVE_SWITCH);
            $form->switch('is_hidden')->states($this->IS_HIDDEN_SWITCH);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
