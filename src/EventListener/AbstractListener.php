<?php

namespace Newball\Common\EventListener;

use Newball\Common\Log\LoggerI;
use Newball\Common\Log\TraitLogger;
use Newball\Common\Message\TraitMessage;

abstract class AbstractListener implements LoggerI {
	use TraitMessage;
	use TraitLogger;
}