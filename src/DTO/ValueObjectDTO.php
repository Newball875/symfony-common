<?php

namespace Newball\Common\DTO;

readonly class ValueObjectDTO implements DTOI {
	public mixed $value;
	public string $label;

	public function __construct(mixed $value, string $label){
		$this->value = $value;
		$this->label = $label;
	}
}