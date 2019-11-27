<?php

namespace Tests\Feature;

use App\Console\Commands\QACommand;
use App\Events\QAndAEvent;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AddQuestionsTest extends TestCase
{
    public function test_it_should_save_a_new_question()
    {
        // Arrange
        $expectedQuestion = '2 + 2 / 2';
        $expectedAnswer = 3;

        // Act
        $this->artisan(QACommand::class)
            ->expectsQuestion('Give the question', $expectedQuestion)
            ->expectsQuestion("Give the answer for: [$expectedQuestion]", $expectedAnswer)
            ->expectsOutput($expectedQuestion)
            ->expectsOutput($expectedAnswer)
            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->assertExitCode(0);

        // Assert
        $this->assertDatabaseHas('questions', ['question' => $expectedQuestion, 'answer' => $expectedAnswer]);
    }

    public function test_it_should_save_a_new_question_twice()
    {
        // Arrange
        Event::fake([QAndAEvent::class]);
        $expectedQuestion1 = '2 + 2 / 2';
        $expectedAnswer1 = 3;

        $expectedQuestion2 = '2 + 2 * 2';
        $expectedAnswer2 = 6;

        // Act
        $this->artisan(QACommand::class)
            ->expectsQuestion('Give the question', $expectedQuestion1)
            ->expectsQuestion("Give the answer for: [$expectedQuestion1]", $expectedAnswer1)
            ->expectsOutput($expectedQuestion1)
            ->expectsOutput($expectedAnswer1)
            ->expectsQuestion('Select the action on the below list', '+ Questions and Answers')
            ->assertExitCode(0);

        // Event gets triggered and QACommand will run again
        $this->artisan(QACommand::class)
            ->expectsQuestion('Give the question', $expectedQuestion2)
            ->expectsQuestion("Give the answer for: [$expectedQuestion2]", $expectedAnswer2)
            ->expectsOutput($expectedQuestion2)
            ->expectsOutput($expectedAnswer2)
            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->assertExitCode(0);

        // Assert
        $this->assertDatabaseHas('questions', ['question' => $expectedQuestion1, 'answer' => $expectedAnswer1]);
        $this->assertDatabaseHas('questions', ['question' => $expectedQuestion2, 'answer' => $expectedAnswer2]);
    }
}
