<?php

namespace LatteBundle;

use LatteBundle\DependencyInjection\Compiler\TemplatingPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LatteBundle extends Bundle
{
	public function build(Containerbuilder $container)
	{
		parent::build($container);

		$container->addCompilerPass(new TemplatingPass());
	}
}
