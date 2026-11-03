<?php

namespace Newball\Common\Log;

use Newball\Common\Exception\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait TraitLogger {
	private LoggerInterface $logger;

	#[Required]
	public function setLogger(LoggerInterface $logger): void{
		$this->logger = $logger;
	}

	protected function logException(Exception $exception){
		$this->logger->error($exception->getMessage(), [
			"code" => $exception->getCode(),
			"app_code" => $exception->getAppCode()
		]);
	}
}