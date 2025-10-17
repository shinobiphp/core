<?php
// src/Kernel/Discovery/Attributes/Discoverable.php
declare(strict_types=1);

namespace Shinobi\Discovery\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Discoverable
{
    public function __construct(
        public readonly ?string $context = null,
        public readonly ?string $description = null
    ) {}
}
