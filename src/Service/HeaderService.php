<?php

namespace Newball\Common\Service;

use Newball\Common\Exception\Exception;
use Newball\Common\Message\Header as HeaderMessage;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class HeaderService {
	private string $tokenName;
	private string $tokenStatus;
	private string $tokenId;

	public function __construct(string $tokenName, string $tokenStatus, string $tokenId){
		$this->tokenName = $tokenName;
		$this->tokenStatus = $tokenStatus;
		$this->tokenId = $tokenId;
	}

	public function getId(Request $request): ?int{
		$id = $request->headers->get($this->tokenId);
		if($id){
			return intval($id);
		}
		return null;
	}

	#[AsMessageHandler]
	public function getIdMessage(HeaderMessage\GetIdMessage $message): ?int{
		$request = $message->getRequest();
		$id = $request->headers->get($this->tokenId);
		if($id){
			return intval($id);
		}
		return null;
	}

	public function getForceId(Request $request): int{
		$id = $this->getId($request);
		if($id == null){
			throw Exception::noDataHeader("Id de l'utilisateur manquant dans les headers");
		}
		return $id;
	}

	public function isStatusOk(Request $request): bool{
		return $request->headers->get($this->tokenStatus) == "Valid";
	}

	public function getToken(Request $request): string{
		return $request->headers->get($this->tokenName) ?? "";
	}
}