<?php

namespace Newball\Common\Resolver;

use Newball\Common\DTO\EntityDTO;
use Newball\Common\Entity\Entity;
use Newball\Common\Repository\RepositoryI;

/**
 * @template T of Entity
 * @template TDTO of EntityDTO
 */
abstract class AbstractResolver {
	private RepositoryI $rep;

	public function __construct(RepositoryI $rep){
		$this->rep = $rep;
	}

	abstract public function supports(mixed $item): bool;

	/**
	 * @param T $entity
	 * @return TDTO
	 */
	abstract public function toDTO(Entity $entity): EntityDTO;

	/**
	 * @param iterable<T> $entities
	 * @return iterable<TDTO>
	 */
	abstract public function allToDTO(iterable $entities): iterable;
}