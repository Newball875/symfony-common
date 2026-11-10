<?php

namespace Newball\Common\Resolver;

use Newball\Common\DTO\EntityDTO;
use Newball\Common\Repository\RepositoryI;

abstract class AbstractResolver {
	private RepositoryI $rep;

	public function __construct(RepositoryI $rep){
		$this->rep = $rep;
	}

	abstract public function supports(string $class): bool;

	/**
	 * @param object $entity
	 * @return EntityDTO
	 */
	abstract public function toDTO(object $entity): EntityDTO;

	/**
	 * @param iterable<object> $entities
	 * @return iterable<EntityDTO>
	 */
	abstract public function allToDTO(iterable $entities): iterable;
}