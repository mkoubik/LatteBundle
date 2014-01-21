<?php

use LatteBundle\Bridge\Nette\Templating\EventedTemplateFactory;
use Symfony\Component\Templating\Storage;
use Symfony\Component\EventDispatcher\EventDispatcher;

require_once __DIR__ . '/../bootstrap.php';

$mockista = new Mockista\Registry();

$_storage = new Storage\StringStorage('test');
$_template = $mockista->create('Nette\Templating\ITemplate');

$wrappedFactory = $mockista
	->create('LatteBundle\Bridge\Nette\Templating\TemplateFactoryInterface');
$wrappedFactory->expects('createFromStorage')->once()->with($_storage)->andReturn($_template);

$eventDispatcher = new EventDispatcher();
$called = false;
$eventDispatcher->addListener('latte.create_template', function($event) use (&$called, $_template) {
	Assert::type('LatteBundle\Event\TemplateEvent', $event);
	Assert::same($_template, $event->getTemplate());
	$called = true;
});

$factory = new EventedTemplateFactory($wrappedFactory, $eventDispatcher);


$template = $factory->createFromStorage($_storage);
Assert::true($called);
Assert::same($_template, $template);

$mockista->assertExpectations();
