<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Aggregate;

abstract class AggregateRoot
{
    private array $recordedEvents = [];
    private int $version = 0;

    abstract public function getAggregateId(): string;

    protected function recordThat(object $event): void
    {
        $this->recordedEvents[] = $event;
        $this->apply($event);
        $this->version++;
    }

    abstract protected function apply(object $event): void;

    public function getRecordedEvents(): array
    {
        return $this->recordedEvents;
    }

    public function clearRecordedEvents(): void
    {
        $this->recordedEvents = [];
    }

    public function getVersion(): int
    {
        return $this->version;
    }
}
