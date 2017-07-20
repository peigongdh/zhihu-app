<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('notification.index', compact('user'));
    }

    public function show(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return redirect(request('redirect_url'));
    }

}
