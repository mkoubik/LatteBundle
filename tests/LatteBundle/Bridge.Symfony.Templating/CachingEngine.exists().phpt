<?php

use LatteBundle\Bridge\Symfony\Templating\CachingEngine;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\Templating\Storage\StringStorage;

require_once __DIR__ . '/../bootstrap.php';

class TestingEngine extends CachingEngine
{
	public function render($name, array $parameters = array()) {}
}

$mockista = new Mockista\Registry();

$_template1 = new TemplateReference('template1.latte', 'latte');
$_storage1 = new StringStorage('test');
$_template2 = new TemplateReference('template2.latte', 'latte');

$parser = $mockista->create('Symfony\Component\Templating\TemplateNameParserInterface');
$parser->expects('parse')->once()->with('template1.latte')->andReturn($_template1);
$parser->expects('parse')->once()->with('template2.latte')->andReturn($_template2);

$loader = $mockista->create('Symfony\Component\Templating\Loader\LoaderInterface');
$loader->expects('load')->once()->with($_template1)->andReturn($_storage1);
$loader->expects('load')->once()->with($_template2)->andThrow(new \InvalidArgumentException());

$engine = new TestingEngine($parser, $loader);

Assert::true($engine->exists('template1.latte'));
Assert::false($engine->exists('template2.latte'));

$mockista->assertExpectations();
