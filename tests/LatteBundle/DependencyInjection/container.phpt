<?php

require_once __DIR__ . '/../bootstrap.php';

require_once __DIR__ . '/../../integration/kernel.php';

$kernel = new TestKernel('test', false);
$kernel->boot();
$container = $kernel->getContainer();

$engine = $container->get('templating.engine.latte');
Assert::type('Symfony\Component\Templating\EngineInterface', $engine);
Assert::type('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface', $engine);

Assert::type('Nette\Latte\Parser', $container->get('latte.parser'));
Assert::type('Nette\Latte\Compiler', $container->get('latte.compiler'));

Assert::true($container->has('latte.filter'));
Assert::true($container->has('latte.listener.cache'));
