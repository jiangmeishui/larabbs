<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 获取登录用户所有未读通知
        $notifications = Auth::user()->notifications()->paginate(20);
        // 标记为已读,未读数量清空
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
