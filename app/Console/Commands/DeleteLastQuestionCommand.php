<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\ActionChoices;
use App\Console\Commands\Concerns\ActionsCommands;
use App\Console\Commands\Concerns\NextCommand;
use App\Console\Commands\Concerns\PrevCommandHandle;
use App\Question;
use Illuminate\Console\Command;

class DeleteLastQuestionCommand extends Command implements ActionsCommands
{
    use NextCommand, ActionChoices, PrevCommandHandle;

    protected $signature = 'qanda:interactive:delete_question {--prev=: Previous Command}';
    protected $description = 'Delete last question.';

    public function handle(): void
    {
        /** @var \Illuminate\Database\Eloquent\Model $question */
        $question = Question::orderBy('id', 'DESC')->first();

        if ($this->confirm("Delete [$question->question]?")) {
            $question->forceDelete();
            $this->info('Record has been deleted.');
        }

        $action = $this->choices();

        $this->dispatchEvent($action);
    }

    public function actions(): array
    {
        return ['menu' => 'Menu', 'qa' => '+ Questions and Answers'];
    }

    public function commands(): array
    {
        return ['menu' => MenuCommand::class, 'qa' => QACommand::class];
    }
}
