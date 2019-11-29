<?php

namespace App\Console\Commands;

use App\Answer;
use App\Console\Commands\Concerns\ActionChoices;
use App\Console\Commands\Concerns\ActionsCommands;
use App\Console\Commands\Concerns\NextCommand;
use App\Console\Commands\Concerns\PrevCommandHandle;
use App\Question;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class PracticeCommand extends Command implements ActionsCommands
{
    use NextCommand, ActionChoices, PrevCommandHandle;

    const QUIT_QUESTIONS = 'Quit questions';
    const DELETE_ANSWER = 'Delete last answer';

    protected $signature = 'qanda:interactive:practice {--prev=: Previous Command}';
    protected $description = 'Practice questions.';

    public function handle(): void
    {
        $allQuestions = Question::all();

        if ($allQuestions->isEmpty()) {
            $this->error('No questions available');

            $action = $this->choices();
            $this->dispatchEvent($action);
        } else {
            $this->questionsAndAnswers($allQuestions);
        }
    }

    private function progress(Collection $questions): Collection
    {
        $bar = $this->output->createProgressBar(count($questions));

        $answers = Answer::where('correct', true)->get();
        $remainingQuestions = $questions->filter(function ($question) use ($answers, $bar) {
            if ($answers->contains('question_id', $question->id)) {
                $bar->advance();

                return false;
            }

            return true;
        });

        $progress = (int) round($bar->getProgressPercent() * 100, 0);
        $bar->finish();

        $this->info("Your current progress is $progress%");

        return $remainingQuestions;
    }

    private function isAnswerCorrect(Collection $questions, string $question, $answer): bool
    {
        $key = $questions->search(function($q) use ($question) {
            if ($q->question == $question || $q->id == $question) {
                return $q;
            }

            return false;
        });

        $currentQuestion = $questions->get($key);

        return Answer::create([
            'question_id' => $currentQuestion->id,
            'answer' => $answer,
            'correct' => $currentQuestion->answer == $answer
        ])->correct;
    }

    private function buildQuestions(Collection $questions)
    {
        $regularQuestions = $questions
            ->mapWithKeys(function($question) {
                return [$question['id'] => $question['question']];
            })
            ->toArray();

        $regularQuestions[] = self::DELETE_ANSWER;
        $regularQuestions[] = self::QUIT_QUESTIONS;

        return $regularQuestions;
    }

    private function questionsAndAnswers($allQuestions): void
    {
        $questions = $this->progress($allQuestions);
        $question = $this->choice('Choose the question:', $this->buildQuestions($questions));

        if ($question == self::QUIT_QUESTIONS) {
            $action = $this->choices();
            $this->dispatchEvent($action);

            return;
        }

        if ($question == self::DELETE_ANSWER) {
            $this->dispatchEvent($question);
            return;
        }

        $answer = $this->ask("Answer:");

        $this->isAnswerCorrect($questions, $question, $answer) ?
            $this->info('Correct Answer!') : $this->error('Incorrect!');

        $this->questionsAndAnswers($allQuestions);
    }

    public function actions(): array
    {
        // TODO: review actions, step back,
        return ['menu' => 'Menu', ];
    }

    public function commands(): array
    {
        return ['menu' => MenuCommand::class, self::DELETE_ANSWER => DeleteLastAnswerCommand::class];
    }
}
