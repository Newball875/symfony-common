<?php

namespace Newball\Common\EventListener;

use Newball\Common\Log\LoggerI;
use Newball\Common\Log\TraitLogger;
use Newball\Common\Message\TraitInternalMessage;

abstract class AbstractListener implements LoggerI {
	use TraitInternalMessage;
	use TraitLogger;
}