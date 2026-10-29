<?php

namespace Newball\Common\Message\Header;

use Newball\Common\Message\AbstractMessage;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends AbstractMessage<?int>
 * @method static static message(Request $request)
 */
readonly class GetIdMessage extends AbstractMessage {
	protected function __construct(private Request $request){
		parent::__construct();
	}

	public function getRequest(): Request {
		return $this->request;
	}
}