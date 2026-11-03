<?php

namespace Newball\Common\DependencyInjection;

use Newball\Common\Log\LoggerI;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class NewballCommonExtension extends Extension {
	public function load(array $configs, ContainerBuilder $container): void {
		$container->registerForAutoconfiguration(LoggerI::class)
			->addTag("monolog.logger", ["channel" => "newball_bundle"]);
	}
}