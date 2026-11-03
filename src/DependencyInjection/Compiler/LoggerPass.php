<?php

namespace Newball\Common\DependencyInjection\Compiler;

use Newball\Common\Log\LoggerI;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LoggerPass implements CompilerPassInterface {

	/**
	 * @inheritDoc
	 */
	public function process(ContainerBuilder $container): void {
		foreach($container->getDefinitions() as $definition) {
			$class = $definition->getClass();

			if($class && is_subclass_of($class, LoggerI::class)) {
				$definition->addTag("monolog.logger", ["channel" => "newball_common"]);
			}
		}
	}
}