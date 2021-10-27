<?php

namespace App\Custom\Functions;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Notification;

class Notify
{
    public static function send_notification(User $user, $title, $message)
    {
        Notification::create(['user_id' => $user->id, 'title' => $title, 'message' => $message]);
    }
}
