<?php

namespace Newball\Common\Factory;

use Doctrine\Common\Collections\Collection;
use Newball\Common\DTO\DTOI;
use Newball\Common\Entity\Entity;
use Newball\Common\ValueObject\ValueObjectI;

/**
 * Classe qui établit les règles d'une factory entre une entité et un DTO
 * @template T of Entity|ValueObjectI
 * @template DTO of DTOI
 */
abstract class AbstractFactory {
	/**
	 * @param T $entity
	 * @return DTO
	 */
	static abstract public function toDTO(Entity|ValueObjectI $entity, ?FactoryContext $context = null): DTOI;

	/**
	 * @param iterable<T> $entities Entités à passer sous DTO
	 * @return DTO[]
	 */
	static public function allToDTO(iterable $entities, ?FactoryContext $context = null): array {
		if($entities instanceof Collection){
			return $entities->map(fn(Entity|ValueObjectI $entity) => static::toDTO($entity, $context))->getValues();
		}

		if(is_array($entities)){
			return array_map(
				fn(Entity|ValueObjectI $entity) => static::toDTO($entity, $context),
				$entities
			);
		}

		$dtos = [];
		foreach ($entities as $entity){
			$dtos[] = static::toDTO($entity, $context);
		}
		return $dtos;
	}
}