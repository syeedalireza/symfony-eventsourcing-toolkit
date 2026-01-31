<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Tests\Unit\Snapshot;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\Connection;
use Syeedalireza\EventSourcingToolkit\Snapshot\SnapshotStore;

final class SnapshotStoreTest extends TestCase
{
    public function testSaveSnapshot(): void
    {
        $connection = $this->createMock(Connection::class);
        $connection->expects($this->once())->method('insert');

        $store = new SnapshotStore($connection);
        $store->save('agg-1', new \stdClass(), 5);

        $this->assertTrue(true);
    }
}
