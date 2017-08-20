<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/8/20
 * Time: 21:01
 */

namespace App\Http\Controllers;


class ActionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('action.index');
    }

}