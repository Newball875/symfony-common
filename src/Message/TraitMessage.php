<?php

namespace Newball\Common\Message;

use Newball\Common\Exception\Exception;
use Newball\Common\Log\TraitLogger;
use Newball\Common\Resolver\TraitResolver;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Contracts\Service\Attribute\Required;

trait TraitMessage {
	private MessageBusInterface $bus;

	use TraitResolver;
	use TraitLogger;

	#[Required]
	public function setMessageBus(MessageBusInterface $bus): void{
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
		try{
			$enveloppe = $this->bus->dispatch($message);
			$handleStamp = $enveloppe->last(HandledStamp::class);
			if(!$handleStamp instanceof HandledStamp){
				throw Exception::noHandler(message: sprintf("Aucun handler pour le message: %s", $message::class));
			}

			return $handleStamp->getResult();
		}catch(Exception $e){
			throw $e;
		}catch(HandlerFailedException $hfe){
			$this->logError(sprintf("Erreur dans la gestion de %s", $message::class), []);

			$exception = $hfe->getPrevious();
			if($exception instanceof Exception){
				throw $exception;
			}else{
				$message = $exception->getMessage();
				throw Exception::handlerError("Erreur dans le handler : $message");
			}
		}catch(\Exception $ex){
			$message = $ex->getMessage();
			throw Exception::handlerError("Erreur dans le handler : $message");
		}
	}
}