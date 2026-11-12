<?php

namespace Newball\Common\Factory;

use Newball\Common\DTO\EntityDTO;
use Newball\Common\Entity\Entity;

/**
 * @template T of Entity
 * @template DTO of EntityDTO
 */
interface FactoryI {
	/**
	 * @param T $entity
	 * @param mixed ...$kwargs
	 * @return DTO
	 */
	static public function toDTO(Entity $entity, mixed ...$kwargs): EntityDTO;

	/**
	 * @param iterable<T> $entities
	 * @param mixed ...$kwargs
	 * @return DTO[]
	 */
	static public function allToDTO(iterable $entities, ...$kwargs): array;
}