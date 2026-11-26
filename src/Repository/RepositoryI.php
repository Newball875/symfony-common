<?php

namespace Newball\Common\Repository;

use Newball\Common\Entity\Entity;

/**
 * @template T of Entity
 */
interface RepositoryI {
	/**
	 * @param integer $id
	 * @return T|null
	 */
	public function findById(int $id): ?Entity;

	/**
	 * @param int[] $ids
	 * @return T[]
	 */
	public function findByIds(array $ids): array;
}