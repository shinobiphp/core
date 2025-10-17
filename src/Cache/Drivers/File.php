<?php

declare(strict_types=1);

namespace Shinobi\Cache\Drivers;

use Shinobi\Cache\Interfaces\Driver as DriverInterface;

final class File implements DriverInterface
{
    public function __construct(private readonly string $dir)
    {
        if (!is_dir($dir)) mkdir($dir, 0777, true);
    }

    public function get(string $key): mixed
    {
        $path = $this->getPath($key);
        if (!file_exists($path)) return null;
        $data = file_get_contents($path);
        return $data === false ? null : unserialize($data);
    }

    public function set(string $key, mixed $value, ?int $ttl = null): void
    {
        file_put_contents($this->getPath($key), serialize($value));
    }

    public function delete(string $key): void
    {
        $path = $this->getPath($key);
        if (file_exists($path)) unlink($path);
    }

    public function clear(): void
    {
        foreach (glob($this->dir . '/*.cache') as $file) {
            unlink($file);
        }
    }

    private function getPath(string $key): string
    {
        return $this->dir . '/' . md5($key) . '.cache';
    }
}
