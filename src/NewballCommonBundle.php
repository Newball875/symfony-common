<?php

namespace Newball\Common;

use Newball\Common\EventListener\CorsListener;
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
				->scalarNode("header_name")
					->defaultValue("X-Auth-Token")
					->info("Nom du header HTTP pour le token")
				->end()
				->scalarNode("header_status")
					->defaultValue("X-Auth-Status")
					->info("Nom du header HTTP pour le statut de l'authentification")
				->end()
				->scalarNode("header_user_id")
					->defaultValue("X-User-Id")
					->info("Nom du header HTTP pour l'id de l'utilisateur authentifié")
				->end()

				->scalarNode("cors_active")
					->defaultValue(true)
					->info("Active ou non la partie CORS de NewballCommon")
				->end()
				->scalarNode("cors_origins")
					->defaultValue("")
					->info("Liste des origins, séparées par une virgule sans espace, autorisées.")
				->end()
				->scalarNode("cors_methods")
					->defaultValue("GET,POST,PUT,PATCH,DELETE,OPTIONS")
					->info("Liste des methods, séparées par une virgule sans espace, autorisées.")
				->end()
				->scalarNode("cors_headers")
					->defaultValue("Accept,Content-Type,Range,Authorization")
					->info("Liste des headers, séparés par une virgule sans espace, autorisés. Prend automatiquement en compte les headers personnalisés")
				->end()
				->scalarNode("cors_exposes")
					->defaultValue("Content-Name,Content-Type,Content-Range")
					->info("Liste des headers, séparés par une virgule sans espace, autorisés.")
				->end()
				->scalarNode("cors_credentials")
					->defaultValue(false)
					->info("Active ou non les credentials, les cookies.")
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
				->autoconfigure()
			->set(CorsListener::class)
				->autowire()
				->autoconfigure()
				->arg('$isActive', $config["cors_active"])
				->arg('$origins', $config["cors_origins"])
				->arg('$methods', $config["cors_methods"])
				->arg('$headers', $config["cors_headers"])
				->arg('$exposes', $config["cors_exposes"])
				->arg('$credentials', $config["cors_credentials"])

				->arg('$tokenName', $config["header_name"])
				->arg('$tokenStatus', $config["header_status"])
				->arg('$tokenId', $config["header_user_id"])
			->autowire()
			->autoconfigure()
		;
	}

	public function prependExtension(ContainerConfigurator $configurator, ContainerBuilder $builder): void {
		$builder->prependExtensionConfig("newball_common", [
			"header_name" => "%env(NB_COMMON_TOKEN_NAME)%",
			"header_status" => "%env(TOKEN_STATUS)%",
			"header_user_id" => "%env(TOKEN_ID)%",

			"cors_active" => "%env(NB_COMMON_CORS_ACTIVE)%",
		    "cors_origins" => "%env(NB_COMMON_CORS_ORIGINS)%",
		    "cors_methods" => "%env(NB_COMMON_CORS_METHODS)%",
		    "cors_headers" => "%env(NB_COMMON_CORS_HEADERS)%",
		    "cors_exposes" => "%env(NB_COMMON_CORS_EXPOSE)%",
		    "cors_credentials" => "%env(NB_COMMON_CORS_CREDENTIALS)%"
		]);
	}
}