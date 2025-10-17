<?php

declare(strict_types=1);

namespace Shinobi\CSR;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Closure;
use ReflectionClass;
use ReflectionParameter;

final class Csr implements ContainerInterface
{
    private array $definitions = [];
    private array $singletons = [];
    private array $tags = [];

    // --- single definition ---
    public function addDefinition(string $id, object $definition, ?array $tags = null, bool $singleton = false): void
    {
        if ($singleton && !($definition instanceof Closure)) {
            $this->singletons[$id] = $definition;
        } else {
            $this->definitions[$id] = $definition;
        }

        if ($tags) {
            $this->tags[$id] = $tags;
        }
    }

    // --- batch definitions ---
    public function addDefinitions(array $defs): void
    {
        foreach ($defs as $id => $definition) {
            $this->addDefinition($id, $definition);
        }
    }

    // --- static builder ---
    public static function build(array $defs = []): self
    {
        $csr = new self();
        $csr->addDefinitions($defs);
        return $csr;
    }

    // --- get ---
    public function get(string $id): mixed
    {
        if (isset($this->singletons[$id])) {
            return $this->singletons[$id];
        }

        if (isset($this->definitions[$id])) {
            $def = $this->definitions[$id];
            $value = $def instanceof Closure ? $def($this) : $def;
            return $value;
        }

        throw new class("Service $id not found") extends \Exception implements NotFoundExceptionInterface {};
    }

    public function has(string $id): bool
    {
        return isset($this->definitions[$id]) || isset($this->singletons[$id]);
    }

    public function getByTag(string $tag): array
    {
        $services = [];
        foreach ($this->tags as $id => $tags) {
            if (in_array($tag, $tags, true)) {
                $services[$id] = $this->get($id);
            }
        }
        return $services;
    }

    public function addSingleton(string $id, object $instance, ?array $tags = null): void
    {
        $this->addDefinition($id, $instance, $tags, true);
    }

    // --- minimal autowiring ---
    public function make(string $class, array $args = []): object
    {
        $ref = new ReflectionClass($class);
        if (!$constructor = $ref->getConstructor()) {
            return new $class();
        }

        $params = [];
        foreach ($constructor->getParameters() as $param) {
            $paramClass = $param->getType()?->getName();
            if ($paramClass && $this->has($paramClass)) {
                $params[] = $this->get($paramClass);
            } elseif (array_key_exists($param->name, $args)) {
                $params[] = $args[$param->name];
            } elseif ($param->isDefaultValueAvailable()) {
                $params[] = $param->getDefaultValue();
            } else {
                throw new \RuntimeException("Cannot resolve parameter {$param->name} for {$class}");
            }
        }

        return $ref->newInstanceArgs($params);
    }
}
