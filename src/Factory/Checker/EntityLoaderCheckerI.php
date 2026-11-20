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

	/**
	 * Vérifie si un objet est bien initialisé
	 *
	 * @param object|null $entity
	 * @return boolean
	 */
	public static function isRelationLoaded(?object $entity): bool;
}