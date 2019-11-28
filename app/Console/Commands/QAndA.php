<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class QAndA extends Command
{
    protected $signature = 'qanda:interactive';
    protected $description = 'Runs an interactive command line based Q And A system.';

    public function handle(): void
    {
        $this->call(MenuCommand::class);
    }
}
