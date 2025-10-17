<?php
declare(strict_types=1);

namespace Shinobi\Cognition\Perception\Interfaces;

interface Perception
{
    /** Receive an event or message */
    public function perceive(mixed $input): void;

    /** Process queued perceptions into internal state */
    public function process(): void;
}
