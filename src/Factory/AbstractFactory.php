<?php

namespace Newball\Common\Factory;

use Newball\Common\DTO\EntityDTO;
use Newball\Common\Entity\Entity;
use Newball\Common\ValueObject\ValueObjectI;

/**
 * Classe qui établit les règles d'une factory entre une entité et un DTO
 * @template T of Entity|ValueObjectI
 * @template DTO of EntityDTO
 * @method EntityDTO static toDTO(Entity $entity, mixed ...$kwargs)
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
}