<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\ActionChoices;
use App\Console\Commands\Concerns\ActionsCommands;
use App\Console\Commands\Concerns\NextCommand;
use App\Console\Commands\Concerns\PrevCommandHandle;
use App\Question;
use Illuminate\Console\Command;

class QACommand extends Command implements ActionsCommands
{
    use NextCommand, ActionChoices, PrevCommandHandle;

    protected $signature = 'qanda:interactive:qa {--prev=: Previous Command}';
    protected $description = 'Create questions and correct answers.';

    public function handle(): void
    {
        $question = $this->ask('Give the question');
        $answer = $this->ask("Give the answer for: [$question]");

        $this->info($question);
        $this->comment($answer);

        Question::forceCreate(compact('question', 'answer'));

        $action = $this->choices();

        $this->dispatchEvent($action);
    }

    public function actions(): array
    {
        return ['menu' => 'Menu', 'qa' => '+ Questions and Answers', 'back' => 'Go back one step'];
    }

    public function commands(): array
    {
        return ['menu' => MenuCommand::class, 'qa' => QACommand::class, 'back' => DeleteLastQuestionCommand::class];
    }
}
