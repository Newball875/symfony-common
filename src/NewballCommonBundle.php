<?php

namespace Newball\Common;

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

	public function loadExtension(array $config, ContainerConfigurator $configurator, ContainerBuilder $container): void {
		$configurator->parameters()
			->set("header_name", $config["header_name"])
			->set("header_status", $config["header_status"])
			->set("header_user_id", $config["header_user_id"])
			->set("cors_active", $config["cors_active"])
			->set("cors_origins", $config["cors_origins"])
			->set("cors_methods", $config["cors_methods"])
			->set("cors_headers", $config["cors_headers"])
			->set("cors_exposes", $config["cors_exposes"])
			->set("cors_credentials", $config["cors_credentials"])
		;

		$configurator->import("../config/services.yaml");
	}
}