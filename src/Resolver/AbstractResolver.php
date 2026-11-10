<?php

namespace Newball\Common\Resolver;

use Newball\Common\Repository\RepositoryI;

abstract class AbstractResolver {
	private RepositoryI $rep;

	public function __construct(RepositoryI $rep){
		$this->rep = $rep;
	}
}