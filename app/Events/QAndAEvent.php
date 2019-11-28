<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Console\Command;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QAndAEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $currentCommand;
    private $nextCommand;

    public function __construct(Command $currentCommand, string $nextCommand)
    {
        $this->currentCommand = $currentCommand;
        $this->nextCommand = $nextCommand;
    }

    public function getCurrentCommand(): Command
    {
        return $this->currentCommand;
    }

    public function getNextCommand(): string
    {
        return $this->nextCommand;
    }
}
