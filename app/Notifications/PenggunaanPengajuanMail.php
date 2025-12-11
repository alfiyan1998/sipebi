<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PenggunaanPengajuanMail extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $status;
    public $statusColor;
    public $items;
    public $id;
    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $status, $statusColor, $items, $id)
    {
        $this->title       = $title;
        $this->message     = $message;
        $this->status      = $status;
        $this->statusColor = $statusColor ?? 'primary';
        $this->items       = $items;
        $this->id          = $id;
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
            ->view(
                'emails.persetujuan', // template email premium
                [
                    'title'      => $this->title,
                    'user'       => $notifiable->name,
                    'content'    => $this->message,
                    'status'     => $this->status,
                    'statusColor'=> $this->statusColor,
                    'items'      => $this->items,
                    'url'        => url('/admin/penggunaans/' . $this->id),
                ]
            );
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
