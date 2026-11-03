<?php

namespace Newball\Common\Service;

use Newball\Common\Log\LoggerI;
use Newball\Common\Log\TraitLogger;
use Newball\Common\Message\TraitMessage;

abstract class AbstractService implements LoggerI {
	use TraitMessage;
	use TraitLogger;
}