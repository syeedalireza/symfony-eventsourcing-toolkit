<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\EventStore;

use Doctrine\DBAL\Connection;

final class EventStore
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function append(string $aggregateId, array $events, int $expectedVersion): void
    {
        foreach ($events as $event) {
            $this->connection->insert('event_store', [
                'aggregate_id' => $aggregateId,
                'event_type' => get_class($event),
                'event_data' => json_encode($event),
                'occurred_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            ]);
        }
    }

    public function load(string $aggregateId): array
    {
        $rows = $this->connection->fetchAllAssociative(
            'SELECT * FROM event_store WHERE aggregate_id = ? ORDER BY id ASC',
            [$aggregateId]
        );

        return array_map(fn($row) => json_decode($row['event_data'], true), $rows);
    }
}
