<?php

namespace App\Console\Commands;

use App\Answer;
use Illuminate\Console\Command;

class ResetCommand extends Command
{
    protected $signature = 'qanda:reset';
    protected $description = 'Reset all previous progresses';

    public function handle(): void
    {
        Answer::truncate();
        $this->info('All the answers have been deleted.');
    }
}
