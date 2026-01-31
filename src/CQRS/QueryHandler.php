<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\CQRS;

/**
 * Base interface for query handlers.
 */
interface QueryHandler
{
    public function handle(Query $query): mixed;
}
