<?php
declare(strict_types=1);

namespace Shinobi\Runtime\Interfaces;

use Shinobi\Kernel\Kernel;

interface Runtime
{
    public static function boot(): self;
    public function run(): int;
}
