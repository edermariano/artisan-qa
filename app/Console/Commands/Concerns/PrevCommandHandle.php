<?php

namespace App\Console\Commands\Concerns;

trait PrevCommandHandle
{
    private $prev;

    public function handle(): void {
        $this->prev = $this->option('--prev');

        parent::handle();
    }
}
