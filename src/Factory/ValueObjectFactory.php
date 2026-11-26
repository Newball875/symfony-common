<?php

namespace Newball\Common\Factory;

use Newball\Common\DTO\ValueObjectDTO;
use Newball\Common\Exception\Exception;
use Newball\Common\Exception\ExceptionCode;
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

	protected static function createContext(): FactoryContext {
		throw new Exception("Aucun context pour cette Factory", 500, ExceptionCode::NOT_REGISTERED);
	}
}