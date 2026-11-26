<?php

namespace Newball\Common\Factory;

use Newball\Common\DTO\ValueObjectDTO;
use Newball\Common\ValueObject\ValueObjectI;

/**
 * @extends AbstractFactory<ValueObjectI, ValueObjectDTO>
 */
class ValueObjectFactory extends AbstractFactory {

	/**
	 * @param ValueObjectI $entity
	 * @return ValueObjectDTO
	 */
	public static function toDTO($entity, ?FactoryContext $context = null): ValueObjectDTO {
		return new ValueObjectDTO(
			value: $entity->getValue(),
			label: $entity->getLabel()
		);
	}
}