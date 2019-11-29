<?php

namespace App\Console\Commands\Concerns;

use App\Events\QAndAEvent;

trait NextCommand
{
    use QuitPrompt;

    protected function fetchNextCommand($action): string
    {
        $context = array_keys($this->actions() + $this->commonActions, $action);

        $context = $context[0] ?? $action;

        return $this->commands()[$context] ?? 'quit';
    }

    protected function dispatchEvent($action): void
    {
        $next = $this->fetchNextCommand($action);

        if ($next === 'quit') {
            $this->quit();
            return;
        }

        event(new QAndAEvent($this, $next));
    }
}
