<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\ActionChoices;
use App\Console\Commands\Concerns\ActionsCommands;
use App\Console\Commands\Concerns\NextCommand;
use App\Console\Commands\Concerns\PrevCommandHandle;
use App\Answer;
use Illuminate\Console\Command;

class DeleteLastAnswerCommand extends Command implements ActionsCommands
{
    use NextCommand, ActionChoices, PrevCommandHandle;

    protected $signature = 'qanda:interactive:delete_answer {--prev=: Previous Command}';
    protected $description = 'Delete last answer.';

    public function handle(): void
    {
        /** @var \Illuminate\Database\Eloquent\Model $answer */
        $answer = Answer::orderBy('id', 'DESC')->first();

        if (!$answer) {
            $this->info('There is no answer to delete.');
        } else {
            if ($this->confirm("Delete [$answer->answer]?")) {
                $answer->forceDelete();
                $this->info('Record has been deleted.');
            }
        }

        $action = $this->choices();

        $this->dispatchEvent($action);
    }

    public function actions(): array
    {
        return ['menu' => 'Menu', 'pq' => 'Keep practicing'];
    }

    public function commands(): array
    {
        return ['menu' => MenuCommand::class, 'pq' => PracticeCommand::class];
    }
}
