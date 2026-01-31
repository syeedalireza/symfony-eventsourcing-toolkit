<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\CQRS;

/**
 * Base interface for command handlers.
 */
interface CommandHandler
{
    public function handle(Command $command): void;
}
