<?php

namespace Tests\Feature;

use App\Answer;
use App\Console\Commands\PracticeCommand;
use App\Question;
use Tests\TestCase;

class PracticeQuestionsTest extends TestCase
{
    public function test_it_should_show_no_questions_message_when_there_is_no_questions()
    {
        // Act \ Assert
        $this->artisan(PracticeCommand::class)
            ->expectsOutput('No questions available')
            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->assertExitCode(0);
    }

    public function test_it_should_show_progress_0_if_there_is_no_answers()
    {
        // Arrange
        factory(Question::class, 3)->create();

        // Act \ Assert
        $this->artisan(PracticeCommand::class)
            ->expectsOutput('Your current progress is 0%')
            ->expectsQuestion('Choose the question:', PracticeCommand::QUIT_QUESTIONS)
            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->assertExitCode(0);
    }

    public function test_it_should_show_progress_0_if_the_answers_are_incorrect()
    {
        // Arrange
        $questions = factory(Question::class, 3)->create();

        factory(Answer::class, 5)->create([
            'question_id' => $questions->shuffle()->first()->id,
            'correct' => false,
        ]);

        // Act \ Assert
        $this->artisan(PracticeCommand::class)
            ->expectsOutput('Your current progress is 0%')
            ->expectsQuestion('Choose the question:', PracticeCommand::QUIT_QUESTIONS)
            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->assertExitCode(0);
    }

    public function test_it_should_show_progress_100_if_the_answers_for_all_questions_are_correct()
    {
        // Arrange
        factory(Answer::class)->create(['correct' => true]);
        factory(Answer::class)->create(['correct' => true]);
        factory(Answer::class)->create(['correct' => true]);

        // Act \ Assert
        $this->artisan(PracticeCommand::class)
            ->expectsOutput('Your current progress is 100%')
            ->expectsOutput('You finish all the questions!')

            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->assertExitCode(0);
    }

    public function test_it_should_show_progress_25_if_the_answers_for_a_quarter_of_questions_are_correct()
    {
        // Arrange
        factory(Answer::class)->create(['correct' => false]);
        factory(Answer::class)->create(['correct' => false]);
        factory(Answer::class)->create(['correct' => false]);
        factory(Answer::class)->create(['correct' => true]);

        // Act \ Assert
        $this->artisan(PracticeCommand::class)
            ->expectsOutput('Your current progress is 25%')
            ->expectsQuestion('Choose the question:', PracticeCommand::QUIT_QUESTIONS)
            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->assertExitCode(0);
    }

    public function test_it_should_be_able_to_delete_the_last_answer()
    {
        // Arrange
        $firstAnswer = factory(Answer::class)->create(['correct' => false]);
        $answerToBeDeleted = factory(Answer::class)->create(['correct' => true]);

        // Act \ Assert
        $this->artisan(PracticeCommand::class)
            ->expectsOutput('Your current progress is 50%')
            ->expectsQuestion('Choose the question:', PracticeCommand::DELETE_ANSWER)
            ->expectsQuestion("Delete [$answerToBeDeleted->answer]?", 'yes')
            ->expectsOutput('Record has been deleted.')
            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->assertExitCode(0);

        $this->assertDatabaseHas('answers', ['id' => $firstAnswer->id]);
        $this->assertDatabaseMissing('answers', ['id' => $answerToBeDeleted->id]);
    }

    public function test_it_should_show_the_progress_after_the_answer()
    {
        // Arrange
        $question1 = factory(Question::class)->create();
        $question2 = factory(Question::class)->create();
        $question3 = factory(Question::class)->create();
        $question4 = factory(Question::class)->create();

        // Act \ Assert
        $this->artisan(PracticeCommand::class)
            ->expectsOutput('Your current progress is 0%')
            ->expectsQuestion('Choose the question:', $question1->question)
            ->expectsQuestion("Answer:", $question1->answer)
            ->expectsOutput('Correct Answer!')

            ->expectsOutput('Your current progress is 25%')
            ->expectsQuestion('Choose the question:', $question2->question)
            ->expectsQuestion("Answer:", 'incorrect answer')
            ->expectsOutput('Incorrect!')

            ->expectsOutput('Your current progress is 25%')
            ->expectsQuestion('Choose the question:', PracticeCommand::QUIT_QUESTIONS)
            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->assertExitCode(0);
    }

    public function test_it_should_show_the_overview_if_all_questions_get_answered()
    {
        // Arrange
        $question1 = factory(Question::class)->create();
        $question2 = factory(Question::class)->create();

        // Act \ Assert
        $this->artisan(PracticeCommand::class)
            ->expectsOutput('Your current progress is 0%')
            ->expectsQuestion('Choose the question:', $question1->question)
            ->expectsQuestion("Answer:", $question1->answer)
            ->expectsOutput('Correct Answer!')

            ->expectsOutput('Your current progress is 50%')
            ->expectsQuestion('Choose the question:', $question2->question)
            ->expectsQuestion("Answer:", $question2->answer)
            ->expectsOutput('Correct Answer!')

            ->expectsOutput('Your current progress is 100%')
            ->expectsOutput('You finish all the questions!')

            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->assertExitCode(0);
    }
}
