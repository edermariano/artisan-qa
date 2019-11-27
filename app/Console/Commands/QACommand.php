<?php

namespace App\Console\Commands;

use App\Question;

class QACommand extends CommonCommand
{
    protected $signature = 'qanda:interactive:qa {--prev=: Previous command}';

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
        return [
            'menu' => 'Menu',
            'qa' => '+ Questions and Answers',
        ];
    }

    public function commands(): array
    {
        return [
            'menu' => MenuCommand::class,
            'qa' => QACommand::class,
        ];
    }
}
