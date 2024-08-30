<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where(DB::raw('`notifications`.`user_id`'), Auth::id())
            ->orWhereNull('user_id')->with(['user' => function($query){
                $query->where('id', Auth::id());
            }])->where('created_at', '>', Auth::user()->created_at)->latest('id')->limit(20)->get();

        $notificationInsert = [];
        foreach ($notifications as $notification) {
            if ($notification->user == '[]') {
                $notificationInsert[] = $notification->id;
            }
        }

        if ($notificationInsert) {
            Auth::user()->notificationsMany()->attach($notificationInsert);
        }

        $notificationList = [];
        foreach ($notifications as $notification) {
            $notificationList[] = [
                'title' => $notification->title,
                'icon' => $notification->icon,
                'created_at' => $notification->convert_date
            ];
        }

        return response()->json($notificationList);
    }
}
