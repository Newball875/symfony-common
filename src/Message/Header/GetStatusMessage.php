<?php

namespace Newball\Common\Message\Header;

use Newball\Common\Message\DomainMessage;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends DomainMessage<bool>
 * @method static static message(Request $request)
 */
readonly class GetStatusMessage extends DomainMessage {
	protected function __construct(private Request $request){
		parent::__construct();
	}

	public function getRequest(): Request {
		return $this->request;
	}
}