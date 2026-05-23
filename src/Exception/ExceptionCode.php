<?php

namespace Newball\Common\Exception;

/**
 * Codes d'exception liés au fonctionnement de l'application
 * Nécessaires pour comprendre la raison exacte de l'erreur
 * A ne pas confondre avec le code HTTP
 */
enum ExceptionCode : int {
	/// CODES 0XXX : DÉFAULT ///

	case DEFAULT = 000;

	/// CODES 1XX : AUTHENTIFICATION ///

	/**
	 * Erreur aucun token fourni
	 */
	case NO_TOKEN = 101;

	/**
	 * Erreur token invalide
	 */
	case INVALID_TOKEN = 102;

	/**
	 * Erreur token inconnu en base
	 */
	case UNKNOWN_TOKEN = 103;

	/**
	 * Erreur token expiré
	 */
	case EXPIRED_TOKEN = 104;

	/**
	 * Erreur token révoqué
	 */
	case REVOKED_TOKEN = 105;

	public static function isAuthError(int $app_code):bool{
		return $app_code >= 100 && $app_code <= 199;
	}

	/// CODES 2XX : MAUVAIS ENVOI DE DONNÉES ///

	/**
	 * Erreur de données fournies incomplètes
	 */
	case POST_DATA = 201;

	/**
	 * Erreur d'informations de connexion
	 */
	case CREDENTIALS_DATA = 202;

	/**
	 * Pas de route
	 */
	case NO_ROUTE = 203;

	/**
	 * Pas d'item trouvé
	 */
	case NO_ITEM = 204;

	/**
	 * Nom déjà pris
	 */
	case ALREADY_TAKEN = 205;

	/// CODES 3XX : ERREUR FICHIER ///

	/**
	 * Pas de fichier (vidéo ou audio)
	 */
	case NO_FILE = 301;

	/**
	 * Pas d'image
	 */
	case NO_IMAGE = 302;

	/**
	 * Fichier illisible
	 */
	case UNREADABLE_FILE = 303;

	/// CODES 4XX : ERREUR TRAITEMENT INTERNE ///

	/**
	 * Mauvais type
	 */
	case BAD_TYPE = 401;

	/**
	 * Info non renseignée
	 */
	case NOT_REGISTERED = 402;
}
