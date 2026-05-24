<?php

namespace Newball\Common;

use Newball\Common\EventListener\ExceptionListener;
use Newball\Common\Service\HeaderService;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class NewballCommonBundle extends AbstractBundle {

	public function configure(DefinitionConfigurator $definition): void {
		$definition->rootNode()
			->children()
				->scalarNode("header_status")
					->defaultValue("X-Auth-Status")
					->info("Nom du header HTTP pour le statut de l'authentification")
				->end()
				->scalarNode("header_user_id")
					->defaultValue("X-User-Id")
					->info("Nom du header HTTP pour l'id de l'utilisateur authentifié")
				->end()
			->end()
		->end();
	}

	public function loadExtension(array $config, ContainerConfigurator $configurator, ContainerBuilder $builder): void {
		$configurator->services()
			->set(HeaderService::class)
				->autowire()
				->autoconfigure()
				->arg('$tokenStatus', $config["header_status"])
				->arg('$tokenId', $config["header_user_id"])
			->set(ExceptionListener::class)
			->autowire()
			->autoconfigure();
	}

	public function prependExtension(ContainerConfigurator $configurator, ContainerBuilder $builder): void {
		$builder->prependExtensionConfig("newball_common", [
			"header_status" => "%env(TOKEN_STATUS)%",
			"header_user_id" => "%env(TOKEN_ID)%"
		]);
	}
}