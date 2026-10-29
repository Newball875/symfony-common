<?php

namespace Newball\Common\Service;

use Newball\Common\Exception\Exception;
use Newball\Common\Message\Header as HeaderMessage;

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

	#[AsMessageHandler]
	public function getId(HeaderMessage\GetIdMessage $message): ?int{
		$request = $message->getRequest();
		$id = $request->headers->get($this->tokenId);
		if($id){
			return intval($id);
		}
		return null;
	}

	#[AsMessageHandler]
	public function getForceId(HeaderMessage\GetIdForceMessage $message): int{
		$id = $this->getId(HeaderMessage\GetIdMessage::message($message->getRequest()));
		if($id == null){
			throw Exception::noDataHeader("Id de l'utilisateur manquant dans les headers");
		}
		return $id;
	}

	#[AsMessageHandler]
	public function isStatusOk(HeaderMessage\GetStatusMessage $message): bool{
		$request = $message->getRequest();
		return $request->headers->get($this->tokenStatus) == "Valid";
	}

	#[AsMessageHandler]
	public function getToken(HeaderMessage\GetTokenMessage $message): ?string{
		$request = $message->getRequest();
		return $request->headers->get($this->tokenName) ?? "";
	}
}