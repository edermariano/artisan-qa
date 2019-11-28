<?php

namespace App\Console\Commands\Concerns;

trait QuitPrompt
{
    private $commonActions = ['quit' => 'Quit'];

    protected function quit(): void
    {
        $this->confirm('Quit, are you sure?') ? $this->info('Bye!') : $this->call(get_class($this));
    }
}
