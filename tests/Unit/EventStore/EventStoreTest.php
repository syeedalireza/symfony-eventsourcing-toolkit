<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Tests\Unit\EventStore;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\Connection;
use Syeedalireza\EventSourcingToolkit\EventStore\EventStore;

final class EventStoreTest extends TestCase
{
    public function testAppendEvents(): void
    {
        $connection = $this->createMock(Connection::class);
        $connection->expects($this->once())->method('insert');

        $eventStore = new EventStore($connection);
        $eventStore->append('aggregate-1', [new \stdClass()], 0);

        $this->assertTrue(true);
    }
}
