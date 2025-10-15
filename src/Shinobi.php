<?php
declare(strict_types=1);

namespace Shinobi;

class Shinobi {
    protected function __construct(protected String $root) {

    }

    public static function boot(String $root): self
    {
        $app = new static(root: $root);

        return $app;
    }
}