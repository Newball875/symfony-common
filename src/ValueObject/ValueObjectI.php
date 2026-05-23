<?php

namespace Newball\Common\ValueObject;

/**
 * @template T_Return
 */
interface ValueObjectI {
	public function getLabel(): string;

	/**
	 * @return T_Return
	 */
	public function getValue(): mixed;

	static public function fromLabel(string $label): self;

	/**
	 * @param T_Return $value
	 * @return self
	 */
	static public function fromValue(mixed $value): self;

	/**
	 * @return self[]
	 */
	static public function getAll(): array;
}