<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppNotification extends Notification
{
    use Queueable;
    
    protected $notificationData;
    protected $notificationFrom;
    

    /**
     * Create a new notification instance.
     * Informationモデル (=お知らせ) を受け取る
     */
    public function __construct($notificationData, $notificationFrom)
    {
        $this->notificationData = $notificationData;
        $this->notificationFrom = $notificationFrom;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
        // return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     * 一旦使わないのでコメントアウト
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     * toArray() メソッドで通知に使用したいデータを配列で返す
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'notification_data' => $this->notificationData,
            'notification_from' => $this->notificationFrom,
            'notification' => $this, // 通知自体をビューに渡す
        ];
    }
}
