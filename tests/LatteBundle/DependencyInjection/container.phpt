<?php

require_once __DIR__ . '/../bootstrap.php';

class TestKernel extends Symfony\Component\HttpKernel\Kernel
{
	public function registerBundles()
	{
		return array(
			new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
			new Symfony\Bundle\AsseticBundle\AsseticBundle(),
			new LatteBundle\LatteBundle(),
		);
	}

	public function registerContainerConfiguration(Symfony\Component\Config\Loader\LoaderInterface $loader)
	{
		$loader->load(__DIR__ . '/config.yml');
	}

	public function getRootDir()
	{
		return TEMP_DIR;
	}
}


$kernel = new TestKernel('test', false);
$kernel->boot();

$container = $kernel->getContainer();

Assert::type('Symfony\Component\Templating\EngineInterface', $container->get('templating.engine.latte'));
Assert::type('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface', $container->get('templating.engine.latte'));

Assert::type('Nette\Latte\Parser', $container->get('latte.parser'));
Assert::type('Nette\Latte\Compiler', $container->get('latte.compiler'));
Assert::true($container->has('latte.filter'));
