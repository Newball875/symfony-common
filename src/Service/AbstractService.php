<?php

namespace Newball\Common\Service;

use Newball\Common\Exception\Exception;
use Newball\Common\Exception\ExceptionCode;
use Newball\Common\Message\AbstractMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

abstract class AbstractService {
	private MessageBusInterface $bus;

	protected function __construct(
		MessageBusInterface $bus
	){
		$this->bus = $bus;
	}

	/**
	 * @template T
	 * @param AbstractMessage<T> $message
	 * @return T
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