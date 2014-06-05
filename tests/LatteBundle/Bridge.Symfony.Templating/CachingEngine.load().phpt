<?php

use LatteBundle\Bridge\Symfony\Templating\CachingEngine;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\Templating\Storage\StringStorage;

require_once __DIR__ . '/../bootstrap.php';

Tester\Environment::$checkAssertions = false;

class TestingEngine extends CachingEngine
{
	public function load($name)
	{
		return parent::load($name);
	}

	public function render($name, array $parameters = array()) {}
}

$mockista = new Mockista\Registry();

$_template = new TemplateReference('template.latte', 'latte');
$_storage = new StringStorage('test');

$parser = $mockista->create('Symfony\Component\Templating\TemplateNameParserInterface');
$parser->expects('parse')->twice()->with('template.latte')->andReturn($_template);

$loader = $mockista->create('Symfony\Component\Templating\Loader\LoaderInterface');
$loader->expects('load')->once()->with($_template)->andReturn($_storage);

$engine = new TestingEngine($parser, $loader);

$engine->load('template.latte');
$engine->load('template.latte');

$mockista->assertExpectations();
