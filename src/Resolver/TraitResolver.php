<?php

namespace Newball\Common\Resolver;

use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Contracts\Service\Attribute\Required;

trait TraitResolver {
	/**
	 * @var iterable<AbstractResolver>
	 */
	private iterable $resolvers;

	/**
	 * @param iterable<AbstractResolver> $resolvers
	 */
	#[Required]
	public function setResolvers(#[AutowireIterator("newball.resolver")] iterable $resolvers): void {
		$this->resolvers = $resolvers;
	}

	protected function getResolver(mixed $item): ?AbstractResolver {
		foreach ($this->resolvers as $resolver){
			if($resolver->supports($item)){
				return $resolver;
			}
		}
		return null;
	}
}