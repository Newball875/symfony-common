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
 * @template Context of FactoryContext
 * @method static DTO toDTO(T $entity, ?Context $context = null)
 */
abstract class AbstractFactory {
	/**
	 * @param iterable<T> $entities Entités à passer sous DTO
	 * @param Context $context
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