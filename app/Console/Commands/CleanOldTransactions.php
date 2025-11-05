<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Carbon\Carbon;

class CleanOldTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete transactions older than 3 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cleanup of old transactions...');

        $threeDaysAgo = Carbon::now()->subDays(3);
        
        $deletedCount = Transaction::where('created_at', '<', $threeDaysAgo)->delete();

        $this->info("Deleted {$deletedCount} transactions older than 3 days.");
        
        return Command::SUCCESS;
    }
}
