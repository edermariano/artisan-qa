<?php

namespace Tests\Feature;

use App\Answer;
use App\Console\Commands\ResetCommand;
use Tests\TestCase;

class ResetAnswersTest extends TestCase
{
    public function test_it_should_erase_previous_answers()
    {
        // Arrange
        factory(Answer::class, 5)->create(['correct' => true]);

        // Act \ Assert
        $this->artisan(ResetCommand::class)
            ->expectsOutput('All the answers have been deleted.')
            ->assertExitCode(0);

        $this->assertCount(0, Answer::all());
    }
}
