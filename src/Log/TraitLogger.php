<?php

namespace Newball\Common\Log;

use Newball\Common\Exception\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Service\Attribute\Required;

trait TraitLogger {
	private LoggerInterface $logger;

	#[Required]
	public function setLogger(LoggerInterface $logger): void{
		$this->logger = $logger;
	}

	protected function logRequest(Request $req, string $message = "Appel API"): void{
		$this->logger->info($message, [
			"url" => $req->getRequestUri()
		]);
	}

	protected function logException(Exception $exception){
		$this->logger->error($exception->getMessage(), [
			"code" => $exception->getCode(),
			"app_code" => $exception->getAppCode()
		]);
	}
}