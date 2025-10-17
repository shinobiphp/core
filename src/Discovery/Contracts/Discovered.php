<?php
declare(strict_types=1);

namespace Shinobi\Discovery\Contracts;

final readonly class Discovered
{
    public function __construct(
        public string $className,
        public string $filePath,
        public ?string $context = null,
        public ?string $description = null,
        public ?\ReflectionClass $reflection = null
    ) {}
}
