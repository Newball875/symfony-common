<?php

namespace Newball\Common\DependencyInjection;

use Newball\Common\Log\LoggerI;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class NewballCommonExtension extends Extension implements PrependExtensionInterface {
	public function prepend(ContainerBuilder $container): void {
		$container->prependExtensionConfig("monolog", [
			"channels" => ["newball_common"]
		]);
	}

	public function load(array $configs, ContainerBuilder $container): void {
		$container->registerForAutoconfiguration(LoggerI::class)
			->addTag("monolog.logger", ["channel" => "newball_common"]);
	}
}