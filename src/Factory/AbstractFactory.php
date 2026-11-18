<?php

namespace Newball\Common\Factory;

use Newball\Common\DTO\EntityDTO;
use Newball\Common\DRO\EntityDRO;
use Newball\Common\Entity\Entity;
use Newball\Common\ValueObject\ValueObjectI;

/**
 * Classe qui établit les règles d'une factory entre une entité et un DTO
 * @template T of Entity|ValueObjectI
 * @template DTO of EntityDTO
 * @template DRO of EntityDRO
 * @method DTO static toDTO(T $entity, mixed ...$kwargs)
 * @method T static fromDRO(DRO $dro, mixed ...$kwargs)
 */
abstract class AbstractFactory implements FactoryI {
	use TraitFactory;

	/**
	 * @param iterable<T> $entities Entités à passer sous DTO
	 * @param mixed ...$kwargs Paramètres optionnels
	 * @return DTO[]
	 */
	static public function allToDTO(iterable $entities, mixed ...$kwargs): array {
		return self::mapFromEntities($entities, $kwargs);
	}

	/**
	 * @param iterable<DRO> $dros
	 * @param mixed ...$kwargs
	 * @return T[]
	 */
	static public function allFromDRO(iterable $dros, mixed ...$kwargs): array{
		$entities = [];
		foreach($dros as $dro){
			$entities[] = self::fromDRO($dro, $kwargs);
		}
		return $entities;
	}
}