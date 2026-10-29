<?php

namespace Newball\Common\EventListener;

use Newball\Common\Message\MessageTrait;

readonly abstract class AbstractListener {
	use MessageTrait;
}