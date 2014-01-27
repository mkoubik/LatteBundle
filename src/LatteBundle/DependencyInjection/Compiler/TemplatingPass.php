<?php

namespace LatteBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class TemplatingPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
	{
		if (!$container->hasDefinition('latte.listener.helper_services')) {
			return;
		}

		$definition = $container->getDefinition('latte.listener.helper_services');
		foreach ($container->findTaggedServiceIds('templating.helper') as $id => $attributes) {
			$alias = isset($attributes[0]['alias']) ? $attributes[0]['alias'] : null;
			$reference = new Reference($id, $container::EXCEPTION_ON_INVALID_REFERENCE, false);
			$definition->addMethodCall('addHelper', array($reference, $alias));
		}
	}
}
