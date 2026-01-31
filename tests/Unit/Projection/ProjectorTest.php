<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Tests\Unit\Projection;

use PHPUnit\Framework\TestCase;
use Syeedalireza\EventSourcingToolkit\Projection\Projector;

final class ProjectorTest extends TestCase
{
    public function testProjectorCanBeCreated(): void
    {
        $projector = new class extends Projector {
            private array $data = [];

            public function project(object $event): void
            {
                $this->data[] = $event;
            }

            public function reset(): void
            {
                $this->data = [];
            }

            public function getData(): array
            {
                return $this->data;
            }
        };

        $projector->project(new \stdClass());
        
        $this->assertCount(1, $projector->getData());
    }

    public function testResetClearsData(): void
    {
        $projector = new class extends Projector {
            private array $data = [];

            public function project(object $event): void
            {
                $this->data[] = $event;
            }

            public function reset(): void
            {
                $this->data = [];
            }

            public function getData(): array
            {
                return $this->data;
            }
        };

        $projector->project(new \stdClass());
        $projector->reset();
        
        $this->assertCount(0, $projector->getData());
    }
}
