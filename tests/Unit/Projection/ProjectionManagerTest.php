<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Tests\Unit\Projection;

use PHPUnit\Framework\TestCase;
use Syeedalireza\EventSourcingToolkit\EventStore\EventStore;
use Syeedalireza\EventSourcingToolkit\Projection\ProjectionManager;
use Syeedalireza\EventSourcingToolkit\Projection\Projector;

final class ProjectionManagerTest extends TestCase
{
    public function testRegisterProjector(): void
    {
        $eventStore = $this->createMock(EventStore::class);
        $manager = new ProjectionManager($eventStore);

        $projector = new class extends Projector {
            public function project(object $event): void {}
            public function reset(): void {}
        };

        $manager->register($projector);

        $this->assertCount(1, $manager->getProjectors());
    }

    public function testRebuildCallsResetOnAllProjectors(): void
    {
        $eventStore = $this->createMock(EventStore::class);
        $manager = new ProjectionManager($eventStore);

        $resetCalled = false;
        $projector = new class($resetCalled) extends Projector {
            public function __construct(private &$flag) {}
            public function project(object $event): void {}
            public function reset(): void { $this->flag = true; }
        };

        $manager->register($projector);
        $manager->rebuild();

        $this->assertTrue($resetCalled);
    }
}
