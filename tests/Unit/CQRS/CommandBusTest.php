<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Tests\Unit\CQRS;

use PHPUnit\Framework\TestCase;
use Syeedalireza\EventSourcingToolkit\CQRS\CommandBus;

final class CommandBusTest extends TestCase
{
    public function testDispatchCommand(): void
    {
        $bus = new CommandBus();
        $executed = false;
        
        $bus->register('TestCommand', function() use (&$executed) {
            $executed = true;
            return 'result';
        });

        $result = $bus->dispatch(new class {
            public function __toString() { return 'TestCommand'; }
        });

        $this->assertTrue($executed);
    }
}
