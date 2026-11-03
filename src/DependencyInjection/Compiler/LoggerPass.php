<?php

namespace Newball\Common\DependencyInjection\Compiler;

use Newball\Common\Log\LoggerI;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LoggerPass implements CompilerPassInterface {

	public function process(ContainerBuilder $container): void {
		if(!$container->hasDefinition("monolog.logger")){
			return;
		}

		if($container->hasParameter("monolog.additional_channels")){
			$channels = $container->getParameter("monolog.additional_channels");
			$channels[] = "newball_common";
			$container->setParameter("monolog.additional_channels", array_unique($channels));
		}

		foreach ($container->getDefinitions() as $definition) {
			$class = $definition->getClass();
			if(!$class){
				continue;
			}

			$reflection = $container->getReflectionClass($class, false);
			if($reflection && $reflection->implementsInterface(LoggerI::class)){
				$definition->addTag("monolog.logger", ["channel" => "newball_common"]);
			}
		}
	}
}