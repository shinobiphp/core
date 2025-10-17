<?php
declare(strict_types=1);

namespace Shinobi\Modules;

final class BindableComponent extends Component
{
    public function __construct(private string $id) {}

    public function uri(): string
    {
        return $this->id;
    }
}
