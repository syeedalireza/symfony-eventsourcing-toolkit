<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Snapshot;

use Doctrine\DBAL\Connection;

final class SnapshotStore
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function save(string $aggregateId, object $aggregate, int $version): void
    {
        $this->connection->insert('snapshots', [
            'aggregate_id' => $aggregateId,
            'aggregate_data' => serialize($aggregate),
            'version' => $version,
            'created_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ]);
    }

    public function load(string $aggregateId): ?array
    {
        $row = $this->connection->fetchAssociative(
            'SELECT * FROM snapshots WHERE aggregate_id = ? ORDER BY version DESC LIMIT 1',
            [$aggregateId]
        );

        if (!$row) {
            return null;
        }

        return [
            'aggregate' => unserialize($row['aggregate_data']),
            'version' => $row['version'],
        ];
    }
}
