<?php

namespace Newball\Common\Message;

use Newball\Common\Exception\Exception;
use Newball\Common\Resolver\AbstractResolver;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Contracts\Service\Attribute\Required;

trait TraitMessage {
	private MessageBusInterface $bus;
	/**
	 * @var iterable<AbstractResolver>
	 */
	private iterable $resolvers;

	#[Required]
	public function setMessageBus(MessageBusInterface $bus): void{
		$this->bus = $bus;
	}

	/**
	 * @param iterable<AbstractResolver> $resolvers
	 */
	#[Required]
	public function setResolvers(#[AutowireIterator("newball.resolver")] iterable $resolvers): void {
		$this->resolvers = $resolvers;
	}

	/**
	 * Fonction qui envoie un message et renvoie une réponse
	 * @template T
	 * @param AbstractMessage<T> $message
	 * @return T
	 * @throws Exception
	 */
	protected function getMessageResult(AbstractMessage $message): mixed{
		$enveloppe = $this->bus->dispatch($message);
		$handleStamp = $enveloppe->last(HandledStamp::class);
		if(!$handleStamp instanceof HandledStamp){
			throw Exception::noHandler(message: sprintf("Aucun handler pour le message: %s", $message::class));
		}

		$result = $handleStamp->getResult();
		return $result;
	}
}