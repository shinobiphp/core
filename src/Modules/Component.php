<?php
declare(strict_types=1);

namespace Shinobi\Modules;

use Shinobi\Modules\Interfaces\Component as ComponentContract;
use Shinobi\CSR\Csr;

abstract class Component implements ComponentContract
{
    abstract public function uri(): string;

    public function initialize(Csr $csr): void
    {
        // optional override
    }
}
