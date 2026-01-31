<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Tests\Unit\Aggregate;

use PHPUnit\Framework\TestCase;
use Syeedalireza\EventSourcingToolkit\Aggregate\AggregateRepository;
use Syeedalireza\EventSourcingToolkit\Aggregate\AggregateRoot;
use Syeedalireza\EventSourcingToolkit\EventStore\EventStore;

final class AggregateRepositoryTest extends TestCase
{
    public function testSaveAggregate(): void
    {
        $eventStore = $this->createMock(EventStore::class);
        $eventStore->expects($this->once())->method('append');

        $aggregate = new class extends AggregateRoot {
            public function __construct() {
                $this->recordThat(new \stdClass());
            }
            public function getAggregateId(): string { return 'test-123'; }
            protected function apply(object $event): void {}
        };

        $repo = new AggregateRepository($eventStore);
        $repo->save($aggregate);

        $this->assertCount(0, $aggregate->getRecordedEvents());
    }
}
