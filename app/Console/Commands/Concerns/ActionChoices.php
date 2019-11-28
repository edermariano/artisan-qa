<?php

namespace App\Console\Commands\Concerns;

trait ActionChoices
{
    protected function choices(?string $label = null): string
    {
        $actions = $this->actions() + $this->commonActions;

        return $this->choice($label ?? 'Select the action on the below list', array_values($actions));
    }
}
