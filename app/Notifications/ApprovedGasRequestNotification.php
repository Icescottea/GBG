<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\GasRequest;

class ApprovedGasRequestNotification extends Notification implements ShouldQueue
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
            ->subject('Gas Request Approved')
            ->greeting('Dear ' . $notifiable->name . ',')
            ->line('Your gas request has been approved.')
            ->line('Here are your token details:')
            ->line('Token Code: ' . $this->gasRequest->token_id)
            ->line('Gas Type: ' . $this->gasRequest->type)
            ->line('Quantity: ' . $this->gasRequest->quantity)
            ->line('Pickup Before: ' . $this->gasRequest->scheduled_date)
            ->line('Please ensure you collect your gas within the given timeframe.')
            ->line('Thank you for using our service!');
    }
}
