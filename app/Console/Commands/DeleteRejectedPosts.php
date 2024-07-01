<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Console\Command;

class DeleteRejectedPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:delete-rejected';
    protected $description = 'Delete posts with rejected status that haven\'t been updated for 10 days';

    public function handle()
    {
        $tenDaysAgo = Carbon::now()->subDays(10);

        $posts = Post::where('status', 'rejected')
            ->where('updated_at', '<=', $tenDaysAgo)
            ->delete();

        $this->info('Deleted ' . $posts . ' rejected posts.');
    }
}
