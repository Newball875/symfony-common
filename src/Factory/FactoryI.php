<?php

namespace Newball\Common\Factory;

use Newball\Common\DTO\EntityDTO;
use Newball\Common\Entity\Entity;
use Newball\Common\ValueObject\ValueObjectI;

/**
 * @template T of Entity|ValueObjectI
 * @template DTO of EntityDTO
 */
interface FactoryI {
	/**
	 * @param T $entity
	 * @return DTO
	 */
	static public function toDTO(Entity|ValueObjectI $entity): EntityDTO;

	/**
	 * @param iterable<T> $entities
	 * @return DTO[]
	 */
	static public function allToDTO(iterable $entities): array;
}