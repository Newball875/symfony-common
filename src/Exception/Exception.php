<?php

namespace Newball\Common\Exception;

use \Exception as PHPException;

class Exception extends PHPException {
	private ExceptionCode $app_code;

	public function getHttpCode(): int {
		return $this->getCode();
	}

	public function getAppCode(): int {
		return $this->app_code->value;
	}

	public function __construct(
		string $message = "Exception",
		int $code = 404,
		ExceptionCode $app_code = ExceptionCode::DEFAULT
	){
		parent::__construct($message, $code);
		$this->app_code = $app_code;
	}

	/**
	 * Données manquantes dans le POST
	 * @param string $message
	 * @param int $http_code
	 * @param ExceptionCode $app_code
	 */
	public static function noDataPOST(
		string $message = "Données manquantes dans le POST",
		int $http_code = 400,
		ExceptionCode $app_code = ExceptionCode::POST_DATA
	):self{
		return new self($message, $http_code, $app_code);
	}

	/**
	 * Entité non trouvable à cet id
	 * @param string $message
	 * @param int $http_code
	 * @param ExceptionCode $app_code
	 */
	public static function noEntity(
		string $message = "Aucune entité à cet id",
		int $http_code = 404,
		ExceptionCode $app_code = ExceptionCode::NO_ITEM
	):self{
		return new self($message, $http_code, $app_code);
	}

	/**
	 * Route non existante à cette adresse
	 * @param string $message
	 * @param int $http_code
	 * @param ExceptionCode $app_code
	 */
	public static function noRoute(
		string $message = "Aucune route à cette adresse",
		int $http_code = 404,
		ExceptionCode $app_code = ExceptionCode::NO_ROUTE
	):self{
		return new self($message, $http_code, $app_code);
	}
}