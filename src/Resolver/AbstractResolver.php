<?php

namespace Newball\Common\Resolver;

use Newball\Common\DTO\EntityDTO;
use Newball\Common\Entity\Entity;
use Newball\Common\Factory\FactoryI;
use Newball\Common\Repository\RepositoryI;

/**
 * @template T of Entity
 * @template DTO of EntityDTO
 */
abstract class AbstractResolver {
	private RepositoryI $rep;

	public function __construct(RepositoryI $rep){
		$this->rep = $rep;
	}

	abstract public function supports(mixed $item): bool;

	/**
	 * @return class-string<FactoryI<T, DTO>>
	 */
	abstract protected function getFactoryClass(): string;

	/**
	 * @param T $entity
	 * @param mixed ...$kwargs
	 * @return DTO
	 */
	public function toDTO(Entity $entity, mixed ...$kwargs): EntityDTO{
		$factoryClass = $this->getFactoryClass();
		return $factoryClass::toDTO($entity, ...$kwargs);
	}

	/**
	 * @param iterable<T> $entities
	 * @param mixed ...$kwargs
	 * @return iterable<DTO>
	 */
	public function allToDTO(iterable $entities, mixed ...$kwargs): iterable{
		$factoryClass = $this->getFactoryClass();
		return $factoryClass::allToDTO($entities, ...$kwargs);
	}
}