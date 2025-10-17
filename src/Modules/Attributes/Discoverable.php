<?php

declare(strict_types=1);

namespace Shinobi\Modules\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Discoverable
{
    public function __construct(
        public readonly ?string $uri = null
    ) {}
}
