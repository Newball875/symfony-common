<?php

namespace Newball\Common\Factory\Checker;

use Doctrine\Common\Collections\Collection;

interface EntityLoaderCheckerI {
	/**
	 * Vérifie si la Collection est bien initialisée
	 *
	 * @param Collection $collection
	 * @return bool
	 */
	public static function isCollectionLoaded(Collection $collection): bool;

	public static function isRelationLoaded(?object $entity): bool;
}