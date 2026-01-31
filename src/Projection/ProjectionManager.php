<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Projection;

use Syeedalireza\EventSourcingToolkit\EventStore\EventStore;

/**
 * Manages projections and their lifecycle.
 */
final class ProjectionManager
{
    /** @var array<Projector> */
    private array $projectors = [];

    public function __construct(
        private readonly EventStore $eventStore,
    ) {
    }

    public function register(Projector $projector): void
    {
        $this->projectors[] = $projector;
    }

    public function projectAll(): void
    {
        foreach ($this->projectors as $projector) {
            $projector->reset();
        }

        // Load all events and project them
        // This is simplified - in production, you'd stream events
    }

    public function rebuild(): void
    {
        $this->projectAll();
    }

    public function getProjectors(): array
    {
        return $this->projectors;
    }
}
