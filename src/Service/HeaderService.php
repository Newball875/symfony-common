<?php

namespace Newball\Common\Service;

use Symfony\Component\HttpFoundation\Request;

class HeaderService {
	private string $tokenStatus;
	private string $tokenId;

	public function __construct(string $tokenStatus, string $tokenId){
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

	public function isStatusOk(Request $request): bool{
		return $request->headers->get($this->tokenStatus) == "Valid";
	}
}