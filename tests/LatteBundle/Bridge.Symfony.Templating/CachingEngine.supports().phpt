<?php

use LatteBundle\Bridge\Symfony\Templating\CachingEngine;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\Templating\Storage\StringStorage;

require_once __DIR__ . '/../bootstrap.php';

class TestingEngine extends CachingEngine
{
	protected function supportsEngine($engine)
	{
		return $engine === 'latte';
	}

	public function render($name, array $parameters = array()) {}
}

$mockista = new Mockista\Registry();

$parser = $mockista->create('Symfony\Component\Templating\TemplateNameParserInterface');
$parser->expects('parse')->once()->with('template.latte')
	->andReturn(new TemplateReference('template.latte', 'latte'));
$parser->expects('parse')->once()->with('template.twig')
	->andReturn(new TemplateReference('template.twig', 'twig'));

$loader = $mockista->create('Symfony\Component\Templating\Loader\LoaderInterface');

$engine = new TestingEngine($parser, $loader);

Assert::true($engine->supports('template.latte'));
Assert::false($engine->supports('template.twig'));

$mockista->assertExpectations();
