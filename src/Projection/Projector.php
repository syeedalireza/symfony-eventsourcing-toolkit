<?php

declare(strict_types=1);

namespace Syeedalireza\EventSourcingToolkit\Projection;

abstract class Projector
{
    abstract public function project(object $event): void;

    abstract public function reset(): void;
}
