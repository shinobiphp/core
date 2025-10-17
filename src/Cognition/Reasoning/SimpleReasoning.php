<?php
declare(strict_types=1);

namespace Shinobi\Cognition\Reasoning;

use Shinobi\Cognition\Reasoning\Interfaces\Reasoning as ReasoningContract;

final class SimpleReasoning implements ReasoningContract
{
    public function decide(): ?string
    {
        // minimal random decision for now
        return rand(0, 1) ? 'scan_for_modules' : 'wait';
    }
}
