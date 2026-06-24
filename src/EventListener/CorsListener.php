<?php

namespace Newball\Common\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

readonly final class CorsListener implements EventSubscriberInterface {
	private bool $isActive;
	private string $origins;
	private string $methods;
	private string $headers;
	private string $exposes;
	private bool $credentials;

	public function __construct(
		bool $isActive,
		string $origins,
		string $methods,
		string $headers,
		string $exposes,
		bool $credentials
	){
		$this->isActive = $isActive;
		$this->origins = $origins;
		$this->methods = $methods;
		$this->headers = $headers;
		$this->exposes = $exposes;
		$this->credentials = $credentials;
	}

	public static function getSubscribedEvents(): array {
		return [
			KernelEvents::REQUEST => ["onKernelRequest", 250],
			KernelEvents::RESPONSE => ["onKernelResponse", 0]
		];
	}

	private function getOrigins(): array{
		return array_map("trim", explode(",", $this->origins));
	}

	private function isOriginAllowed(?string $origin): bool{
		if(!$origin) return false;

		return in_array($origin, $this->getOrigins(), true);
	}

	#[AsEventListener(event: KernelEvents::REQUEST)]
	public function onKernelRequest(RequestEvent $event): void {
		if(!$event->isMainRequest() || !$this->isActive) return;

		$req = $event->getRequest();
		$origin = $req->headers->get("Origin");

		if($req->getMethod() == "OPTIONS" && $this->isOriginAllowed($origin)){
			$reponse = new Response("", Response::HTTP_NO_CONTENT);

			$reponse->headers->set("Access-Control-Allow-Origin", $origin);
			$reponse->headers->set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, PATCH, OPTIONS");
			$reponse->headers->set("Access-Control-Allow-Headers", "Range, Content-Type, Authorization, NB-WS-Password");


			$event->setResponse($reponse);
		}
	}
	#[AsEventListener(event: KernelEvents::RESPONSE)]
	public function onKernelResponse(ResponseEvent $event): void {
		if(!$this->isActive) return;

		$request = $event->getRequest();
		$origin = $request->headers->get("Origin");

		if($origin && $this->isOriginAllowed($origin)){
			$reponse = $event->getResponse();
			$reponse->headers->set("Access-Control-Allow-Origin", $origin);
			$reponse->headers->set("Access-Control-Allow-Credentials", "true");
		}
	}
}