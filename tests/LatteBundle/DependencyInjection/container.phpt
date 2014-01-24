<?php

require_once __DIR__ . '/../bootstrap.php';

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TestingBundle extends Bundle
{
}

class TestKernel extends Symfony\Component\HttpKernel\Kernel
{
	public function registerBundles()
	{
		return array(
			new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
			new Symfony\Bundle\AsseticBundle\AsseticBundle(),
			new LatteBundle\LatteBundle(),
			new TestingBundle(),
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

$request = Symfony\Component\HttpFoundation\Request::create('http://example.com/');
$container->set('request', $request);
$container->enterScope('request');

$engine = $container->get('templating.engine.latte');
Assert::type('Symfony\Component\Templating\EngineInterface', $engine);
Assert::type('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface', $engine);

Assert::type('Nette\Latte\Parser', $container->get('latte.parser'));
Assert::type('Nette\Latte\Compiler', $container->get('latte.compiler'));
Assert::true($container->has('latte.filter'));

$container->get('latte.listener.cache');

$html = $engine->render('TestingBundle:test:hello.html.latte', array('name' => 'WORLD'));
Assert::match('Hello world!', $html);
