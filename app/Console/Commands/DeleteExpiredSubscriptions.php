<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Subscription;
use Illuminate\Console\Command;

class DeleteExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:delete-expired';
    protected $description = 'Delete subscriptions that have ended';

    public function handle()
    {
        $expiredSubscriptions = Subscription::where('ends_at', '<', Carbon::now())->get();

        foreach ($expiredSubscriptions as $subscription) {
            $subscription->delete();
        }

        $this->info('Expired subscriptions deleted successfully.');
    }
}
