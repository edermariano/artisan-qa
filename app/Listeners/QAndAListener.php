<?php

namespace App\Listeners;

use App\Events\QAndAEvent;

class QAndAListener
{
    public function handle(QAndAEvent $event): void
    {
        $event->getCurrentCommand()
            ->call($event->getNextCommand(), ['--prev' => get_class($event->getCurrentCommand())]);
    }
}
