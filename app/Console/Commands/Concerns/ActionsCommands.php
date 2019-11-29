<?php

namespace App\Console\Commands\Concerns;

interface ActionsCommands
{
    function actions(): array;
    function commands(): array;
}
