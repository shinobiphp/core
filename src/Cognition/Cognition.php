<?php
declare(strict_types=1);

namespace Shinobi\Cognition;

use Shinobi\Cognition\Perception\EventPerception;
use Shinobi\Cognition\Perception\Interfaces\Perception;
use Shinobi\Cognition\Reasoning\SimpleReasoning;
use Shinobi\Cognition\Reasoning\Interfaces\Reasoning;
use Shinobi\Cognition\Context\SimpleContext;
use Shinobi\Cognition\Context\Interfaces\Context;

final class Cognition
{
    private Perception $perception;
    private Reasoning $reasoning;
    private Context $context;

    public function __construct()
    {
        $this->perception = new EventPerception();
        $this->reasoning = new SimpleReasoning();
        $this->context = new SimpleContext();
    }

    public function perception(): Perception
    {
        return $this->perception;
    }

    public function reasoning(): Reasoning
    {
        return $this->reasoning;
    }

    public function context(): Context
    {
        return $this->context;
    }

    /** tick cognition: process perceptions + reasoning */
    public function tick(): ?string
    {
        $this->perception->process();
        return $this->reasoning->decide();
    }
}
