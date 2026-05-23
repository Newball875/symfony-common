<?php

namespace Newball\Common\Factory;

use Doctrine\Common\Collections\Collection;
use Newball\Common\DTO\EntityDTO;

/**
 * @method mixed toDTO($entity, mixed ...$kwargs)
 */
trait TraitFactory {
	/**
	 * @param iterable $entities
	 * @param mixed ...$kwargs
	 * @return EntityDTO[]
	 */
	static private function mapFromEntities($entities, mixed ...$kwargs): array{
		if($entities instanceof Collection){
			return self::mapFromCollection($entities, ...$kwargs);
		}

		if(is_array($entities)){
			return self::mapFromArray($entities, ...$kwargs);
		}

		$result = [];
		foreach ($entities as $entity){
			$result[] = static::toDTO($entity, ...$kwargs);
		}
		return $result;
	}

	static private function mapFromArray(array $entities, mixed ...$kwargs): array{
		return array_map(
			fn($entity) => static::toDTO($entity, ...$kwargs),
			$entities
		);
	}

	static private function mapFromCollection(Collection $collection, mixed ...$kwargs): array{
		return $collection->map(fn($entity) => static::toDTO($entity, ...$kwargs))->getValues();
	}
}