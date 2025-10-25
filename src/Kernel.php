<?php
declare(strict_types=1);

namespace Shinobi;

use Shinobi\Shinobi;

final class Kernel {
	private static array $instances = array();

	private function __construct(private Shinobi $shinobi) 
	{
		//
	}

	private function __clone(): never
	{
		throw new \Exception("cannot clone a singleton");
	}

	public function __wakeup(): never
	{
        	throw new \Exception("Cannot unserialize a singleton.");
	}

	public static function instance(Shinobi $shinobi): self
	{
		$tag = $shinobi->guid();

		if (!isset(self::$instances[$tag])) {
			self::$instances[$tag] = new self(shinobi: $shinobi);
		}

		return self::$instances[$tag];
	}
}
