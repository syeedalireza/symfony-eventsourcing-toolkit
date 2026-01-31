<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\CQRS;

final class CommandBus
{
    private array $handlers = [];

    public function register(string $commandClass, callable $handler): void
    {
        $this->handlers[$commandClass] = $handler;
    }

    public function dispatch(object $command): mixed
    {
        $handler = $this->handlers[get_class($command)] ?? null;

        if (!$handler) {
            throw new \RuntimeException('No handler registered for ' . get_class($command));
        }

        return $handler($command);
    }
}
