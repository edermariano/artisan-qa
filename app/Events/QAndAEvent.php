<?php

namespace App\Events;

use App\Console\Commands\CommonCommand;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QAndAEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $currentCommand;
    private $nextCommand;

    public function __construct(CommonCommand $currentCommand, string $nextCommand)
    {
        $this->currentCommand = $currentCommand;
        $this->nextCommand = $nextCommand;
    }

    public function getCurrentCommand(): CommonCommand
    {
        return $this->currentCommand;
    }

    public function getNextCommand(): string
    {
        return $this->nextCommand;
    }
}
