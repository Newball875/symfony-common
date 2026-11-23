<?php

namespace Newball\Common\Service;

use Newball\Common\Log\LoggerI;
use Newball\Common\Log\TraitLogger;
use Newball\Common\Message\TraitInternalMessage;

abstract class AbstractService implements LoggerI {
	use TraitInternalMessage;
	use TraitLogger;
}