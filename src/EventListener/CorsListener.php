<?php

namespace Newball\Common\EventListener;

use Newball\Common\Service\ApiReponse;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

readonly final class CorsListener implements EventSubscriberInterface {
	private bool $isActive;
	private array $origins;
	private array $methods;
	private array $headers;
	private array $exposes;
	private bool $credentials;

	public function __construct(
		string $isActive,
		string $origins,
		string $methods,
		string $headers,
		string $exposes,
		string $credentials,

		string $tokenName,
		string $tokenStatus,
		string $tokenId,
	){
		$this->isActive = filter_var($isActive, FILTER_VALIDATE_BOOLEAN);
		$this->origins = array_map("trim", explode(",", $origins));
		$this->methods = array_map("trim", explode(",", $methods));

		$allHeaders = array_map("trim", explode(",", $headers));
		array_push($allHeaders, $tokenName, $tokenStatus, $tokenId);
		$this->headers = $allHeaders;

		$this->exposes = array_map("trim", explode(",", $exposes));
		$this->credentials = filter_var($credentials, FILTER_VALIDATE_BOOLEAN);
	}

	public static function getSubscribedEvents(): array {
		return [
			KernelEvents::REQUEST => ["onKernelRequest", 250],
			KernelEvents::RESPONSE => ["onKernelResponse", 0]
		];
	}

	private function isOriginAllowed(?string $origin): bool{
		if(!$origin) return false;

		return in_array($origin, $this->origins, true);
	}

	#[AsEventListener(event: KernelEvents::REQUEST)]
	public function onKernelRequest(RequestEvent $event): void {
		if(!$event->isMainRequest() || !$this->isActive) return;

		$req = $event->getRequest();
		$origin = $req->headers->get("Origin");

		if($req->getMethod() == "OPTIONS" && $this->isOriginAllowed($origin)){
			$event->setResponse(ApiReponse::cors($this->origins, $this->methods, $this->headers, $this->exposes));
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
			$reponse->headers->set("Access-Control-Allow-Credentials", $this->credentials ? "true": "false");
		}
	}
}