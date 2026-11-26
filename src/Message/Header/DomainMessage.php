<?php

namespace Newball\Common\Message;

use Newball\Common\Entity\Entity;

/**
 * @template T of Entity|iterable<Entity>|int|iterable<int>|string|iterable<string>|null
 * @extends AbstractMessage<T>
 */
readonly abstract class DomainMessage extends AbstractMessage {}