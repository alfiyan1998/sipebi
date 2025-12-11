<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PenggunaanStatusMail extends Notification
{
    use Queueable;

    public string $title;
    public string $message;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $title, string $message)
    {
        $this->title   = $title;
        $this->message = $message;
    }

    
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->title)
            ->greeting('Halo, ' . $notifiable->name)
            ->line($this->message)
            ->action('Lihat Detail Penggunaan', url('/admin/penggunaans'))
            ->line('Terima kasih telah menggunakan layanan kami.');
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
}
