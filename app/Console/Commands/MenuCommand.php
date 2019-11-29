<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\ActionChoices;
use App\Console\Commands\Concerns\ActionsCommands;
use App\Console\Commands\Concerns\NextCommand;
use App\Console\Commands\Concerns\PrevCommandHandle;
use Illuminate\Console\Command;

class MenuCommand extends Command implements ActionsCommands
{
    use NextCommand, ActionChoices, PrevCommandHandle;

    protected $signature = 'qanda:interactive:menu {--prev=: Previous Command}';
    protected $description = 'Main menu.';

    public function handle(): void
    {
        $action = $this->choices();
        $this->info($action);

        $this->dispatchEvent($action);
    }

    public function actions(): array
    {
        return ['qa' => 'Create Questions and Answers', 'practice' => 'View previously entered Answers',];
    }

    public function commands(): array
    {
        return ['qa' => QACommand::class, 'practice' => PracticeCommand::class];
    }
}
