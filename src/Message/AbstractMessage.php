<?php

namespace Newball\Common\Message;

/**
 * @template T
 */
abstract class AbstractMessage {
	protected function __construct(){}

	public static function message(mixed ...$args): static{
		return new static(...$args);
	}
}