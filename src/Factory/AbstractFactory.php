<?php

namespace Newball\Common\Factory;

use Doctrine\Common\Collections\Collection;
use Newball\Common\DTO\EntityDTO;
use Newball\Common\Entity\Entity;
use Newball\Common\ValueObject\ValueObjectI;

/**
 * Classe qui établit les règles d'une factory entre une entité et un DTO
 * @template T of Entity|ValueObjectI
 * @template DTO of EntityDTO
 * @method DTO static toDTO(T $entity)
 */
abstract class AbstractFactory implements FactoryI {
	/**
	 * @param Entity|ValueObjectI $entity
	 * @return EntityDTO
	 */
	static abstract public function toDTO(Entity|ValueObjectI $entity): EntityDTO;

	/**
	 * @param iterable<T> $entities Entités à passer sous DTO
	 * @return DTO[]
	 */
	static public function allToDTO(iterable $entities): array {
		if($entities instanceof Collection){
			return $entities->map(fn(Entity|ValueObjectI $entity) => static::toDTO($entity))->getValues();
		}

		if(is_array($entities)){
			return array_map(
				fn(Entity|ValueObjectI $entity) => static::toDTO($entity),
				$entities
			);
		}

		$dtos = [];
		foreach ($entities as $entity){
			$dtos[] = static::toDTO($entity);
		}
		return $dtos;
	}
}