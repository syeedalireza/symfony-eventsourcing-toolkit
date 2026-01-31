<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Tests\Unit\Aggregate;

use PHPUnit\Framework\TestCase;
use Syeedalireza\EventSourcingToolkit\Aggregate\AggregateRoot;

final class AggregateRootTest extends TestCase
{
    public function testRecordEvent(): void
    {
        $aggregate = new class extends AggregateRoot {
            private string $id = 'test-123';
            
            public function getAggregateId(): string { return $this->id; }
            
            public function doSomething(): void {
                $this->recordThat(new \stdClass());
            }
            
            protected function apply(object $event): void {}
        };

        $aggregate->doSomething();

        $this->assertCount(1, $aggregate->getRecordedEvents());
    }

    public function testVersionIncrementsOnEvent(): void
    {
        $aggregate = new class extends AggregateRoot {
            public function getAggregateId(): string { return 'test'; }
            public function doAction(): void { $this->recordThat(new \stdClass()); }
            protected function apply(object $event): void {}
        };

        $this->assertEquals(0, $aggregate->getVersion());
        $aggregate->doAction();
        $this->assertEquals(1, $aggregate->getVersion());
    }
}
