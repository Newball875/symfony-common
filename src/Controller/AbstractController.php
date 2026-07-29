<?php

namespace Newball\Common\Controller;

use Newball\Common\DTO\EntityDTO;
use Newball\Common\Exception\Exception;
use Newball\Common\Service\ApiReponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController extends SymfonyController {
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
}