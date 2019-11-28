<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PracticeCommand extends Command
{
    protected $signature = 'qanda:interactive:practice {--prev=: Previous Command}';
    protected $description = 'Practice questions.';

    public function handle(): void
    {
        // TODO: list of progress
        // TODO: Choose the question
        // TODO: Check your progress
        $question = $this->choice('Choose the question:', ['A', 'B', 'C']);
        $answer = $this->ask("Answer for the question: $question");

        $this->info($question);
        $this->comment($answer);

        // TODO: check in the database and fill the answers table
    }

    public function actions(): array
    {
        // TODO: review actions
        return [
            'qa' => 'Create Questions and Answers',
        ];
    }

    public function commands(): array
    {
        return [
            'qa' => QACommand::class,
        ];
    }
}
