<?php

namespace Newball\Common\Message;

/**
 * @template T
 */
readonly abstract class AbstractMessage {
	protected function __construct(){}

	public static function message(mixed ...$args): static{
		return new static(...$args);
	}
}