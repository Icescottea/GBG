<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Delivery;
use App\Models\User;
use App\Notifications\DeliveryReminderNotification;
use Carbon\Carbon;

class SendDeliveryReminders extends Command
{
    protected $signature = 'delivery:reminders';
    protected $description = 'Send reminder emails to token holders one day before delivery';

    public function __construct()
    {        parent::__construct();    }

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $deliveries = Delivery::where('scheduled_date', $tomorrow)->get();

        foreach ($deliveries as $delivery) {
            $tokenUsers = User::whereHas('tokens', function ($query) use ($delivery) {
                $query->where('status', 'active')
                      ->whereHas('gasRequest', function ($q) use ($delivery) {
                          $q->where('outlet_id', $delivery->outlet_id);
                      });
            })->get();

            foreach ($tokenUsers as $user) {
                $user->notify(new DeliveryReminderNotification($delivery));
                \Log::info("Reminder email sent to: " . $user->email);
            }
        }
        $this->info('Reminder emails sent successfully.');
    }
}
