<?php

namespace App\Services;

use Illuminate\Support\Facades\Notification;

class NotificationService
{
    public function sendNotification($notifiable, $notification)
    {
        Notification::send($notifiable, $notification);
    }


    public function markAsRead($notification)
    {
        $notification->markAsRead();
    }
}
