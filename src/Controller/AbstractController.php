<?php

namespace Newball\Common\Controller;

use Newball\Common\DTO\EntityDTO;
use Newball\Common\Entity\Entity;
use Newball\Common\Exception\Exception;
use Newball\Common\Log\LoggerI;
use Newball\Common\Log\TraitLogger;
use Newball\Common\Message\TraitMessage;
use Newball\Common\Resolver\TraitResolver;
use Newball\Common\Service\ApiReponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController extends SymfonyController implements LoggerI {
	use TraitMessage;
	use TraitLogger;
	use TraitResolver;

	/**
	 * Fonction de succès qui retourne les données au format défini
	 * @param string|Entity|iterable<Entity> $data Données à renvoyer
	 * @param int $code => Code de la réponse (200 de base)
	 * @return Response
	 */
	protected function success(Entity|string|array $data, int $code = 200, int $niveau = 0): Response{
		// Si on a une Entity
		if($data instanceof Entity){
			$resolver = $this->getResolver($data);
			return ApiReponse::success($resolver->toDTO($data, $niveau), $code);
		}

		// Si on a un tableau
		if(is_iterable($data) && $data[0] instanceof Entity){
			$dtos = [];
			foreach ($data as $entity){
				$resolver = $this->getResolver($entity);
				if($resolver){
					$dtos[] = $resolver->toDTO($entity);
				}
			}
			return ApiReponse::success($dtos, $code);
		}

		// Si on a un string
		if(is_string($data)){
			return ApiReponse::success($data, $code);
		}

		// Sinon, on lance une erreur
		throw Exception::badReturn();
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
}