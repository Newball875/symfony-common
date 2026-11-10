<?php

namespace Newball\Common\Message;

/**
 * @template T
 * @template TDTO of bool = true
 */
abstract class AbstractMessage {
	private bool $dto;

	protected function __construct(){}

	/**
	 * @param mixed ...$args
	 * @return static<T, true>
	 */
	public static function message(mixed ...$args): static{
		$instance = new static(...$args);
		$instance->dto = true;
		return $instance;
	}

	/**
	 * @return static<T, false>
	 */
	public function withoutDTO(): static {
		$this->dto = false;
		return $this;
	}

	public function useDto(): bool {
		return $this->dto;
	}
}