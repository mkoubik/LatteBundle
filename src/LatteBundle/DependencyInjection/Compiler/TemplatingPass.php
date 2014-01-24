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
			$definition->addMethodCall('addHelper', array(new Reference($id), $alias));
		}
	}
}
