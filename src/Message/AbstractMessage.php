<?php

namespace Newball\Common\Message;

/**
 * @template T
 */
readonly abstract class AbstractMessage {
	private bool $dto;

	protected function __construct(){}

	public static function message(mixed ...$args): static{
		$instance = new static(...$args);
		$instance->dto = true;
		return $instance;
	}

	public function withoutDTO(): static {
		$this->dto = false;
		return $this;
	}

	public function useDto(): bool {
		return $this->dto;
	}
}