<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('notification.index');
    }

    public function show(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return redirect(request('redirect_url'));
    }

}
