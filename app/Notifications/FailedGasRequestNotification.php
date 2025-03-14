<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\GasRequest;

class FailedGasRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $gasRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(GasRequest $gasRequest)
    {
        $this->gasRequest = $gasRequest;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Gas Request Failed')
            ->greeting('Dear ' . $notifiable->name . ',')
            ->line('Unfortunately, your gas request has failed.')
            ->line('The gas has been reallocated due to failure to collect.')
            ->line('If you have any questions, please contact support.')
            ->line('Thank you for your understanding.');
    }
}
