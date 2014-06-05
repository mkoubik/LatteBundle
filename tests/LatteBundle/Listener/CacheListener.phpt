<?php

use LatteBundle\Event\TemplateEvent;
use LatteBundle\Listener\CacheListener;

require_once __DIR__ . '/../bootstrap.php';

Tester\Environment::$checkAssertions = false;

$mockista = new Mockista\Registry();

$cacheStorage = $mockista->create('Nette\Caching\IStorage');
$template = $mockista->create('Nette\Templating\ITemplate');
$template->expects('setCacheStorage')->once()->with($cacheStorage);
$event = new TemplateEvent($template);

$listener = new CacheListener($cacheStorage);

$listener->onCreateTemplate($event);

$mockista->assertExpectations();
