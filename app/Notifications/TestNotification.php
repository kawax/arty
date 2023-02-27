<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class TestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param  string  $body
     * @return void
     */
    public function __construct(protected string $body)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return [DiscordChannel::class];
    }

    public function toDiscord(mixed $notifiable): DiscordMessage
    {
        return DiscordMessage::create($this->body);
    }
}
