<?php

namespace Newball\Common\Message;

use Newball\Common\Entity\Entity;
use Newball\Common\Exception\Exception;
use Newball\Common\Log\TraitLogger;
use Newball\Common\Resolver\TraitResolver;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Trait de gestion des Messages utilisé par les Controllers
 */
trait TraitControllerMessage {
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
	 * @template DTO
	 * @param AbstractMessage<T, DTO> $message
	 * @return DTO|null
	 * @throws Exception
	 */
	protected function getMessageResult(AbstractMessage $message): mixed{
		try{
			$enveloppe = $this->bus->dispatch($message);
			$handleStamp = $enveloppe->last(HandledStamp::class);
			if(!$handleStamp instanceof HandledStamp){
				throw Exception::noHandler(message: sprintf("Aucun handler pour le message: %s", $message::class));
			}

			$result = $handleStamp->getResult();
			if(is_array($result)){
				$dtos = [];
				foreach($result as $item){
					if(is_object($item)){
						$resolver = $this->getResolver($item);
						if($resolver){
							$dtos[] = $resolver->toDTO($item);
						}
					}else{
						$dtos[] = $item;
					}
				}
				return $dtos;
			}else if(is_object($result)){
				$resolver = $this->getResolver($result);
				if($resolver){
					return $resolver->toDTO($result);
				}
				return null;
			}else{
				return $result;
			}
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