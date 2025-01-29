<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Delivery;
use App\Models\Outlet;

class ScheduledDeliveryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $delivery;
    protected $outlet;

    /**
     * Create a new notification instance.
     */
    public function __construct(Delivery $delivery)
    {
        $this->delivery = $delivery;
        $this->outlet = Outlet::find($delivery->outlet_id);
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail']; // Use 'database' if storing in DB
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Upcoming Gas Delivery to ' . $this->outlet->name)
            ->greeting('Dear ' . $notifiable->name . ',')
            ->line('A new gas delivery has been scheduled for your outlet: ' . $this->outlet->name . '.')
            ->line('Please prepare to exchange your empty cylinders and complete your purchase.')
            ->line('Scheduled Delivery Date: ' . $this->delivery->scheduled_date)
            ->line('Thank you for using our service!');
    }
}
