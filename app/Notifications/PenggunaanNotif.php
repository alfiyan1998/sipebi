<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class PenggunaanNotif extends Notification implements ShouldBroadcast
{
    // use Queueable;
    public array $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    
    public function via( $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function broadcastOn()
    {
        return ['private-users.' . $this->data['user_id']];
    }

    /**
     * Notifikasi database.
     */
    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->data['title'] ?? 'Notifikasi',
            'body' => $this->data['body'] ?? '',
            'url' => $this->data['url'] ?? null,
        ];
    }

    /**
     * Notifikasi broadcast.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => $this->data['title'] ?? 'Notifikasi',
            'body' => $this->data['body'] ?? '',
            'url' => $this->data['url'] ?? null,
        ]);
    }
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
