<?php

namespace Newball\Common\Factory;

use Newball\Common\DRO\EntityDRO;
use Newball\Common\DTO\ValueObjectDTO;
use Newball\Common\Exception\Exception;
use Newball\Common\ValueObject\ValueObjectI;

/**
 * @extends AbstractFactory<ValueObjectI, ValueObjectDTO>
 */
class ValueObjectFactory extends AbstractFactory {

	/**
	 * @param ValueObjectI $entity
	 * @return ValueObjectDTO
	 */
	public static function toDTO($entity, ...$kwargs): ValueObjectDTO {
		return new ValueObjectDTO(
			value: $entity->getValue(),
			label: $entity->getLabel()
		);
	}

	/**
	 * @param EntityDRO $dro
	 * @return ValueObjectI
	 */
	public static function fromDRO(EntityDRO $dro, ...$kwargs): ValueObjectI {
		throw new Exception("A voir comment faire du dro depuis ValueObjectI", 400);
	}
}