<?php

namespace Tests\Feature;

use App\Console\Commands\QAndA;
use App\Events\QAndAEvent;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class InitialInteractionTest extends TestCase
{
    /** @dataProvider choicesProvider */
    public function test_it_should_allow_choosing_between_add_questions_answers_or_list_answers($expectedQuestion)
    {
        // Arrange
        Event::fake();

        // Act
        $command = $this->artisan(QAndA::class);

        // Assert
        $command
            ->expectsQuestion('Select the action on the below list', $expectedQuestion)
            ->expectsOutput($expectedQuestion);

        $this->expectsEvents(QAndAEvent::class);
    }

    public function test_it_should_show_confirm_prompt_when_user_wants_to_quit()
    {
        // Arrange
        // Act
        $command = $this->artisan(QAndA::class);

        // Assert
        $command
            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->expectsOutput('Bye!')
            ->assertExitCode(0);
    }

    public function test_it_should_return_to_the_previous_command_if_user_refuse_to_quit()
    {
        // Arrange
        $no = false;

        // Act
        $command = $this->artisan(QAndA::class);

        // Assert
        $command
            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', $no)
            ->expectsQuestion('Select the action on the below list', 'Quit')
            ->expectsQuestion('Quit, are you sure?', 'yes')
            ->expectsOutput('Bye!')
            ->assertExitCode(0);
    }

    public function choicesProvider()
    {
        yield ['Create Questions and Answers'];
        yield ['View previously entered Answers'];
    }
}
