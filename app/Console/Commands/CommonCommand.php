<?php

namespace App\Console\Commands;

use App\Events\QAndAEvent;
use Illuminate\Console\Command;

abstract class CommonCommand extends Command
{
    private $commonActions = ['quit' => 'Quit'];

    protected $prev;

    abstract public function actions(): array;

    abstract public function commands(): array;

    public function handle(): void
    {
        $prevCommand = $this->option('prev');

        if ($prevCommand) {
            $this->setPrev($prevCommand);
        }
    }

    protected function choices(?string $label = null): string
    {
        $actions = $this->actions() + $this->commonActions;

        return $this->choice($label ?? 'Select the action on the below list', array_values($actions));
    }

    protected function quit(): void
    {
        $this->confirm('Quit, are you sure?') ? $this->info('Bye!') : $this->call(get_class($this));
    }

    protected function setPrev($prevCommand): void
    {
        $this->commonActions['prev'] = 'Back';
        $this->prev = $prevCommand;
    }

    protected function fetchNextCommand($action): string
    {
        $context = array_keys($this->actions() + $this->commonActions, $action)[0];

        return $this->commands()[$context] ?? 'quit';
    }

    protected function dispatchEvent($action): void
    {
        $next = $this->fetchNextCommand($action);

        if ($next === 'quit') {
            $this->quit();
        } else {
            event(new QAndAEvent($this, $next));
        }
    }
}
