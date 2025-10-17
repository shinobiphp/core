<?php
declare(strict_types=1);

namespace Shinobi\Cognition\Perception;

use Shinobi\Cognition\Perception\Interfaces\Perception as PerceptionContract;

final class EventPerception implements PerceptionContract
{
    private array $queue = [];

    public function perceive(mixed $input): void
    {
        $this->queue[] = $input;
    }

    public function process(): void
    {
        foreach ($this->queue as $event) {
            echo "[Perception] Processing event: " . json_encode($event) . "\n";
        }
        $this->queue = [];
    }
}
