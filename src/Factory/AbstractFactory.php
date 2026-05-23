<?php

namespace Newball\Common\Factory;

use Newball\Common\DTO\EntityDTO;

use Doctrine\Common\Collections\Collection;

/**
 * Classe qui établit les règles d'une factory entre une entité et un DTO
 * @template T_Value
 * @method EntityDTO toDTO($entity, mixed ...$kwargs)
 */
abstract class AbstractFactory {
	/**
	 * @param T_Value $entity Entité à passer sous DTO
	 * @param mixed ...$kwargs Paramètres optionnels
	 * @return EntityDTO
	 */
	static abstract public function toDTO(mixed $entity, ...$kwargs): EntityDTO;

	/**
	 * @param iterable<T_Value> $entities Entités à passer sous DTO
	 * @param mixed ...$kwargs Paramètres optionnels
	 * @return EntityDTO[]
	 */
	static public function allToDTO(iterable $entities, ...$kwargs): array {
		if($entities instanceof Collection) {
			return static::mapFromCollection($entities);
		}

		if(is_array($entities)){
			return static::mapFromArray($entities);
		}

		$dtos = [];
		foreach($entities as $entity) {
			$dtos[] = static::toDTO($entity);
		}
		return $dtos;
	}

	static private function mapFromArray(array $entities, ...$kwargs): array {
		return array_map(
			fn($entity) => static::toDTO($entity, ...$kwargs),
			$entities
		);
	}

	static private function mapFromCollection(Collection $collection, ...$kwargs): array{
		return $collection->map(fn($entity) => static::toDTO($entity, ...$kwargs))->getValues();
	}
}