<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Aggregate;

use Syeedalireza\EventSourcingToolkit\EventStore\EventStore;
use Syeedalireza\EventSourcingToolkit\Snapshot\SnapshotStore;

/**
 * Repository for event-sourced aggregates.
 */
final class AggregateRepository
{
    public function __construct(
        private readonly EventStore $eventStore,
        private readonly ?SnapshotStore $snapshotStore = null,
    ) {
    }

    public function save(AggregateRoot $aggregate): void
    {
        $events = $aggregate->getRecordedEvents();
        
        if (empty($events)) {
            return;
        }

        $this->eventStore->append(
            $aggregate->getAggregateId(),
            $events,
            $aggregate->getVersion() - count($events)
        );

        $aggregate->clearRecordedEvents();

        // Save snapshot if applicable
        if ($this->snapshotStore && $aggregate->getVersion() % 100 === 0) {
            $this->snapshotStore->save(
                $aggregate->getAggregateId(),
                $aggregate,
                $aggregate->getVersion()
            );
        }
    }

    public function load(string $aggregateId, string $aggregateClass): ?AggregateRoot
    {
        // Load from snapshot if available
        if ($this->snapshotStore) {
            $snapshot = $this->snapshotStore->load($aggregateId);
            if ($snapshot) {
                return $snapshot['aggregate'];
            }
        }

        // Load from events
        $events = $this->eventStore->load($aggregateId);
        
        if (empty($events)) {
            return null;
        }

        // Reconstruct aggregate from events
        // This is simplified - actual implementation would be more complex
        return null;
    }
}
