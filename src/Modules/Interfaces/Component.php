<?php

declare(strict_types=1);

namespace Shinobi\Modules\Interfaces;

use Shinobi\CSR\Csr;

interface Component
{
    /** Unique URI for this component */
    public function uri(): string;

    /** Optional: initialization hook when loaded by CSR */
    public function initialize(Csr $csr): void;
}
