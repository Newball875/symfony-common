<?php

namespace Newball\Common\EventListener;

use Newball\Common\Exception\Exception;
use Newball\Common\Message\AbstractMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

readonly abstract class AbstractListener {
	private MessageBusInterface $bus;

	public function __construct(MessageBusInterface $bus){
		$this->bus = $bus;
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
		return $handleStamp->getResult();
	}
}