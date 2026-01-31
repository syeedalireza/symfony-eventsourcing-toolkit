<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Tests\Unit\CQRS;

use PHPUnit\Framework\TestCase;
use Syeedalireza\EventSourcingToolkit\CQRS\QueryBus;

final class QueryBusTest extends TestCase
{
    public function testAskQuery(): void
    {
        $bus = new QueryBus();
        
        $bus->register('GetUserQuery', function($query) {
            return ['id' => 1, 'name' => 'John'];
        });

        $result = $bus->ask(new class {
            public function __toString() { return 'GetUserQuery'; }
        });

        $this->assertIsArray($result);
        $this->assertEquals('John', $result['name']);
    }

    public function testThrowsExceptionForUnregisteredQuery(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No handler registered');

        $bus = new QueryBus();
        $bus->ask(new class {});
    }
}
