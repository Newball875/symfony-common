<?php

namespace Newball\Common\Message\Header;

use Newball\Common\Message\AbstractMessage;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends AbstractMessage<bool>
 * @method static static message(Request $request)
 */
readonly class GetStatusMessage extends AbstractMessage {
	protected function __construct(private Request $request){
		parent::__construct();
	}

	public function getRequest(): Request {
		return $this->request;
	}
}