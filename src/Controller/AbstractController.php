<?php

namespace Newball\Common\Controller;

use Newball\Common\DTO\EntityDTO;
use Newball\Common\Exception\Exception;
use Newball\Common\Message\AbstractMessage;
use Newball\Common\Service\ApiReponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

abstract class AbstractController extends SymfonyController {
	private MessageBusInterface $bus;

	protected function __construct(
		MessageBusInterface $bus,
	){
		$this->bus = $bus;
	}

	/**
	 * Fonction de succès qui retourne les données au format défini
	 * @param string|EntityDTO|iterable<EntityDTO> $data Données à renvoyer
	 * @param int $code => Code de la réponse (200 de base)
	 * @return Response
	 */
	protected function success(EntityDTO|string|array $data, int $code = 200): Response{
		return ApiReponse::success($data, $code);
	}

	/**
	 * Fonction de succès qui retourne l'image demandée
	 * @param string $file
	 * @param string $source => le chemin pour le proxy du fichier (exemple : /internal-images/fichier.png pour **nginx**)
	 * @param int $code
	 * @return Response
	 * @throws Exception
	 */
	protected function successImage(string $file, string $source, int $code = 200): Response{
		return ApiReponse::image($file, $source, $code);
	}

	/**
	 * Fonction de succès qui retourne la vidéo demandée
	 * @param string $file
	 * @param string $source => le chemin pour le proxy du fichier (exemple : /internal-videos/fichier.mp4 pour **nginx**)
	 * @param int $code
	 * @return Response
	 * @throws Exception
	 */
	protected function successVideo(string $file, string $source, int $code = 200): Response{
		return ApiReponse::video($file, $source, $code);
	}

	/**
	 * Fonction de succès qui retourne l'audio demandée
	 * @param string $file
	 * @param string $source => le chemin pour le proxy du fichier (exemple : /internal-musiques/fichier.mp3 pour **nginx**)
	 * @param int $code
	 * @return Response
	 * @throws Exception
	 */
	protected function successAudio(string $file, string $source, int $code = 200): Response{
		return ApiReponse::audio($file, $source, $code);
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