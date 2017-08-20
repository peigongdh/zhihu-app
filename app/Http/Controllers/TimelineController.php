<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/8/20
 * Time: 21:02
 */

namespace App\Http\Controllers;


class TimelineController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('timeline.index');
    }

}