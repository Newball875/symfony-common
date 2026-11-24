<?php

declare(strict_types=1);

namespace Newball\Common\Factory;

use Doctrine\Common\Collections\Collection;
use Newball\Common\Entity\Entity;
use Newball\Common\Factory\Checker\EntityLoaderCheckerI;
use Newball\Common\ValueObject\ValueObjectI;

/**
 * @template T of Entity|ValueObjectI
 */
final class MappingContext {
	private static ?EntityLoaderCheckerI $defaultLoaderChecker = null;

	private readonly EntityLoaderCheckerI $loaderChecker;
	/** @var array<int, true> ids des entités */
	private readonly array $ancetres;
	private readonly ?int $maxNiveau;

	private function __construct(
		EntityLoaderCheckerI $loaderChecker,
		array $ancetres = [],
		?int $maxNiveau = null
	){
		$this->loaderChecker = $loaderChecker;
		$this->ancetres = $ancetres;
		$this->maxNiveau = $maxNiveau;
	}

	public static function setDefaultLoaderChecker(EntityLoaderCheckerI $loaderChecker): void {
		self::$defaultLoaderChecker = $loaderChecker;
	}

	public static function create(?int $maxNiveau = null, ?EntityLoaderCheckerI $loaderChecker = null): self {
		$checker = $loaderChecker ?? self::$defaultLoaderChecker;
		if($checker === null){
			throw new \Exception("Pas de checker");
		}

		return new self($checker, maxNiveau: $maxNiveau);
	}

	/**
	 * @param T $entity
	 * @return self
	 */
	public function enter(Entity|ValueObjectI $entity): self {
		$ancetres = $this->ancetres;
		$ancetres[spl_object_id($entity)] = true;
		return new self($this->loaderChecker, $ancetres, $this->maxNiveau);
	}

	/**
	 * @param T $entity
	 * @return boolean
	 */
	public function hasVisited(Entity|ValueObjectI $entity): bool {
		return isset($this->ancetres[spl_object_id($entity)]);
	}

	/**
	 * @param ?T $target
	 * @return boolean
	 */
	public function shouldMap(Entity|ValueObjectI|null $target): bool {
		if($target instanceof ValueObjectI){
			return true;
		}

		if($target === null || $this->isDepthExceeded() | $this->hasVisited($target)){
			return false;
		}

		return $this->loaderChecker->isRelationLoaded($target);
	}

	public function shouldMapCollection(Collection $collection): bool {
		if($this->isDepthExceeded()){
			return false;
		}

		return $this->loaderChecker->isCollectionLoaded($collection);
	}

	private function isDepthExceeded(): bool {
		return $this->maxNiveau !== null && count($this->ancetres) > $this->maxNiveau;
	}
}