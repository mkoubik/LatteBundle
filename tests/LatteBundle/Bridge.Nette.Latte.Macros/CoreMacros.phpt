<?php

require_once __DIR__ . '/../bootstrap.php';

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TestingBundle extends Bundle
{
}

require_once __DIR__ . '/../../integration/kernel.php';

$kernel = new TestKernel('test', false);
$request = Symfony\Component\HttpFoundation\Request::create('http://example.com/home');
$kernel->handle($request);
$container = $kernel->getContainer();
$container->set('request', $request);
$container->enterScope('request');
$engine = $container->get('templating.engine.latte');


$html = $engine->render('TestingBundle:test:hello.html.latte', array('name' => 'WORLD'));
Assert::match('Hello world!', $html);

$html = $engine->render('TestingBundle:test:coreMacros.html.latte', array(
    'name' => 'world',
    'empty' => '',
));
Assert::matchFile(__DIR__ . '/expected/coreMacros.html', $html);

$html = $engine->render('TestingBundle:test:uiMacros.html.latte', array());
Assert::matchFile(__DIR__ . '/expected/uiMacros.html', $html);
