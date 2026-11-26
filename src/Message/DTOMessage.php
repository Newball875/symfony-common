<?php

namespace Newball\Common\Message;

use Newball\Common\DTO\DTOI;

/**
 * @template T of DTOI|iterable<DTOI>|int|iterable<int>|string|iterable<string>|null
 * @extends AbstractMessage<T>
 */
readonly abstract class DTOMessage extends AbstractMessage {}