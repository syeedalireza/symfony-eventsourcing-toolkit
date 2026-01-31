<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Tests\Unit\EventStore;

use PHPUnit\Framework\TestCase;
use Syeedalireza\EventSourcingToolkit\EventStore\EventStreamIterator;

final class EventStreamIteratorTest extends TestCase
{
    public function testIteration(): void
    {
        $events = [new \stdClass(), new \stdClass(), new \stdClass()];
        $iterator = new EventStreamIterator($events);

        $count = 0;
        foreach ($iterator as $event) {
            $count++;
        }

        $this->assertEquals(3, $count);
    }

    public function testToArray(): void
    {
        $events = [new \stdClass(), new \stdClass()];
        $iterator = new EventStreamIterator($events);

        $this->assertEquals($events, $iterator->toArray());
    }
}
