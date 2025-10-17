<?php
declare(strict_types=1);

namespace Shinobi\Cognition\Reasoning\Interfaces;

interface Reasoning
{
    /** Decide what to do next if no explicit instructions */
    public function decide(): ?string;
}
