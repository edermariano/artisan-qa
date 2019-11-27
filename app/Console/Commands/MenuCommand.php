<?php

namespace App\Console\Commands;

class MenuCommand extends CommonCommand
{
    protected $signature = 'qanda:interactive:menu {--prev= : Previous Command}';

    protected $description = 'Main menu.';

    public function handle(): void
    {
        $action = $this->choices();

        $this->info($action);

        $this->dispatchEvent($action);
    }

    public function actions(): array
    {
        return [
            'qa' => 'Create Questions and Answers',
            'practice' => 'View previously entered Answers',
        ];
    }

    public function commands(): array
    {
        return [
            'qa' => QACommand::class,
            'practice' => PracticeCommand::class
        ];
    }
}
