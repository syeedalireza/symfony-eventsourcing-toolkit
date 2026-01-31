<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\EventStore;

use Iterator;

/**
 * Iterator for event streams.
 * 
 * @implements Iterator<int, object>
 */
final class EventStreamIterator implements Iterator
{
    private int $position = 0;

    public function __construct(
        private readonly array $events,
    ) {
    }

    public function current(): object
    {
        return $this->events[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->events[$this->position]);
    }

    public function toArray(): array
    {
        return $this->events;
    }
}
