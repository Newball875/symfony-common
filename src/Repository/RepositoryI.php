<?php

namespace Newball\Common\Repository;

use Newball\Common\DTO\EntityDTO;

interface RepositoryI {
	public function supports(string $datatable): bool;

	/**
	 * @param object $entity
	 * @return EntityDTO
	 */
	public function toDTO(object $entity): EntityDTO;

	/**
	 * @param iterable<object> $entities
	 * @return iterable<EntityDTO>
	 */
	public function allToDTO(iterable $entities): iterable;
}