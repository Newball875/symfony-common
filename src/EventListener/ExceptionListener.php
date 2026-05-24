<?php

namespace Newball\Common\EventListener;

use Newball\Common\Exception\Exception;
use Newball\Common\Service\ApiReponse;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Gère le renvoi d'exceptions sous format JSON
 */
final class ExceptionListener {
	#[AsEventListener(event: KernelEvents::EXCEPTION)]
	public function onKernelException(ExceptionEvent $event): void{
		$exception = $event->getThrowable();
		$statusCode = 500;
		$appCode = 0;
		if($exception instanceof Exception){
			$statusCode = $exception->getHttpCode();
			$appCode = $exception->getAppCode();
		}
		$json = ApiReponse::error(
			message: $exception->getMessage(),
			http_code: $statusCode,
			app_code: $appCode
		);
		$event->setResponse($json);
	}
}