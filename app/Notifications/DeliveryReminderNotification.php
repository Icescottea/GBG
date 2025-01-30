<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Delivery;
use App\Models\Outlet;

class DeliveryReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $delivery;
    protected $outlet;

    public function __construct(Delivery $delivery)
    {
        $this->delivery = $delivery;
        $this->outlet = Outlet::find($delivery->outlet_id);
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reminder: Upcoming Gas Delivery to ' . $this->outlet->name)
            ->greeting('Dear ' . $notifiable->name . ',')
            ->line('This is a reminder that a gas delivery is scheduled for tomorrow at your outlet: ' . $this->outlet->name . '.')
            ->line('Please prepare to exchange your empty cylinders and complete your purchase.')
            ->line('Scheduled Delivery Date: ' . $this->delivery->scheduled_date)
            ->line('Thank you for using our service!');
    }
}
