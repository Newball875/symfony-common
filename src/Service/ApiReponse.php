<?php

namespace Newball\Common\Service;

use Newball\Common\Exception\Exception;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

final class ApiReponse {
	/**
	 * Fonction qui récupère les paramètres d'une exception et renvoie un JSON résumant les informations données
	 * @param string $message => Message d'erreur à transmettre
	 * @param int $http_code => Code d'erreur HTTP
	 * @param int $app_code => Code d'erreur de l'application
	 */
	static public function error(string $message, int $http_code, int $app_code): JsonResponse{
		$data = [
			"code" => $app_code,
			"message" => $message
		];
		$response = new JsonResponse($data, $http_code);
		$response->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		return $response;
	}

	/**
	 * Fonction pour renvoyer proprement les informations sous format JSON
	 * @param $data
	 * @param int $code
	 * @return JsonResponse
	 */
	static public function success($data, int $code = 200): JsonResponse{
		$response = new JsonResponse($data, $code);
		$response->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		return $response;
	}

	/**
	 * Fonction qui génère correctement un média audio
	 * @param string $file => Chemin du fichier
	 * @param int $code => code de statut, par défaut 200 (Succès)
	 * @return Response => Média audio généré
	 */
	static public function audio(string $file, int $code = 200): Response{
		if(!file_exists($file)){
			throw Exception::noFile();
		}

		$reponse = new BinaryFileResponse($file, $code);
		BinaryFileResponse::trustXSendfileTypeHeader();

		$reponse->setContentDisposition(
			ResponseHeaderBag::DISPOSITION_INLINE,
			basename($file)
		);

		return $reponse;
	}

	/**
	 * Fonction qui génère correctement un média vidéo
	 * @param string $file => le chemin physique du fichier
	 * @param string $source => le chemin pour le proxy du fichier (exemple : /internal-videos/fichier.mp4 pour **nginx**)
	 * @param int $code
	 * @return StreamedResponse
	 */
	static public function video(string $file, string $source, int $code = 200): Response{
		if(!file_exists($file)){
			throw Exception::noFile();
		}
		if(!is_readable($file)){
			throw Exception::fileNotReadable();
		}

		$reponse = new Response();
		$reponse->headers->set("Access-Control-Allow-Origin", '*');
		$reponse->headers->set("Access-Control-Allow-Credentials", "true");
		$reponse->headers->set("Content-Type", "video/mp4");
		$reponse->headers->set("X-Send-file", $source);
		$reponse->headers->set("X-Accel-Redirect", $source);
		$reponse->headers->set("Content-Disposition", "attachment");
		return $reponse;
	}

	/**
	 * Fonction qui génère correctement un média image
	 * @param string $file
	 * @param int $code
	 * @return Response
	 * @throws Exception
	 */
	static public function image(string $file, int $code = 200): Response{
		if(!file_exists($file)){
			throw Exception::noImage();
		}
		return new Response(file_get_contents($file), $code, [
			"Content-Type" => mime_content_type($file),
			"Content-Disposition" => "inline; filename=\"".basename($file)."\""
		]);
	}

	/**
	 * Fonction qui génère une réponse pour les CORS avec tous les headers nécessaires
	 * @param array $origins
	 * @param array $methods
	 * @param array $headers
	 * @param array $exposes
	 * @return Response
	 */
	static public function cors(array $origins, array $methods, array $headers, array $exposes): Response{
		return new JsonResponse("", Response::HTTP_NO_CONTENT, [
			"Access-Control-Allow-Origin" => $origins,
			"Access-Control-Allow-Methods" => $methods,
			"Access-Control-Allow-Headers" => $headers,
			"Access-Control-Expose-Headers" => $exposes,
		]);
	}
}