<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\CQRS;

final class QueryBus
{
    private array $handlers = [];

    public function register(string $queryClass, callable $handler): void
    {
        $this->handlers[$queryClass] = $handler;
    }

    public function ask(object $query): mixed
    {
        $handler = $this->handlers[get_class($query)] ?? null;

        if (!$handler) {
            throw new \RuntimeException('No handler registered for ' . get_class($query));
        }

        return $handler($query);
    }
}
