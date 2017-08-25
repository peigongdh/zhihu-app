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
        $notifications = user()->notifications;
        $notificationGroups = $notifications->groupBy(function ($item, $key) {
            return substr($item['created_at'], 0, 10);
        });
        return view('notification.index', compact('notificationGroups'));
    }

    public function show(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return redirect(request('redirect_url'));
    }

}
