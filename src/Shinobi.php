<?php

declare(strict_types=1);

namespace Shinobi;

use Shinobi\Kernel\Kernel;

final class Shinobi
{
    public static function boot(string $root): Kernel
    {
        return Kernel::boot($root);
    }
}
