<?php

namespace Newball\Common\EventListener;

use Newball\Common\Exception\Exception;
use Newball\Common\Service\ApiReponse;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Gère le renvoi d'exceptions sous format JSON
 */
final class ExceptionListener extends AbstractListener {
	#[AsEventListener(event: KernelEvents::EXCEPTION)]
	public function returnException(ExceptionEvent $event): void{
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

	#[AsEventListener(event: KernelEvents::EXCEPTION, priority: 10)]
	public function updateException(ExceptionEvent $event): void{
		$exception = $event->getThrowable();
		if($exception instanceof NotFoundHttpException){
			$route = $event->getRequest()->attributes->get("_route");
			$routeException = Exception::noRoute("Aucune route à l'adresse $route");
			$event->setThrowable($routeException);
		}
	}
}
