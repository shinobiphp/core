<?php

declare(strict_types=1);

namespace Shinobi\Discovery\Traits;

use Shinobi\Discovery\Contracts\Discovered;

trait IsDiscoverer
{
    protected array $scanPaths = [__DIR__ . '/../../..'];

    protected function scanPath(string $path): void
    {
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($rii as $file) {
            if (!$file->isFile() || $file->getExtension() !== 'php') continue;

            $fqcn = $this->reflectFile($file->getPathname());
            if (!$fqcn) continue;

            if ($this->isRelevant($fqcn)) {
                $this->handleDiscovered($fqcn, $file->getPathname());
            }
        }
    }

    protected function reflectFile(string $file): ?string
    {
        $classesBefore = get_declared_classes();
        require_once $file;
        $classesAfter = get_declared_classes();
        $newClasses = array_diff($classesAfter, $classesBefore);
        return array_shift($newClasses) ?: null;
    }

    protected function handleDiscovered(string $fqcn, string $filePath): void
    {
        // Each discoverer implements this, can construct Discovered properly
        $reflection = new \ReflectionClass($fqcn);

        $discovered = new Discovered(
            className: $fqcn,
            filePath: $filePath,
            reflection: $reflection
        );

        $this->register($discovered);
    }

    abstract public function register(Discovered $discovered): void;
}