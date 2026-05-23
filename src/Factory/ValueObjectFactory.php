<?php

namespace Newball\Common\Factory;

use Newball\Common\DTO\ValueObjectDTO;
use Newball\Common\ValueObject\ValueObjectI;

class ValueObjectFactory extends AbstractFactory {

	/**
	 * @param ValueObjectI $entity
	 * @return ValueObjectDTO
	 */
	public static function toDTO($entity): ValueObjectDTO {
		return new ValueObjectDTO(
			value: $entity->getValue(),
			label: $entity->getLabel()
		);
	}
}