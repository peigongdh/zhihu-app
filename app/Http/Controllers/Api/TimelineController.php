<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TimelineRepository;
use Illuminate\Http\Request;

class TimelineController extends Controller
{

    protected $timelineRepository;

    public function __construct(TimelineRepository $timelineRepository)
    {
        $this->middleware('auth');
        $this->timelineRepository = $timelineRepository;
    }

    public function index()
    {
        return view('timeline.index');
    }

}
