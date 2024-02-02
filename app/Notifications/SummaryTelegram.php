<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class SummaryTelegram extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     */

    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toTelegram(object $notifiable)
    {
        return TelegramMessage::create()
            ->to($this->data['telegram_user_id'])
            ->content("*=== SUMMARY REPORT TGL ".$this->data['tanggal']." ===*")
            ->line('')
            ->line("Total Locomotif : *".$this->data['total']."*")
            ->line("Total Locomotif Active : *".$this->data['total_active']."*")
            ->line("Total Locomotif Non Active : *".$this->data['total_nonactive']."*");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    /**
     * Route notifications for the Telegram channel.
     *
     * @return int
     */
    public function routeNotificationForTelegram()
    {
        return $this->telegram_user_id;
    }
}
