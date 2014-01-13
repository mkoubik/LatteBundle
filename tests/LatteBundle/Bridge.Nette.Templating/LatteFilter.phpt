<?php

require_once __DIR__ . '/../bootstrap.php';

$mockista = new Mockista\Registry();

$_latteSource = '{latte source}';
$_tokens = array();
$_phpSource = '<?php source;';

$parser = $mockista->create('Nette\Latte\Parser');
$parser->expects('parse')->once()->with($_latteSource)->andReturn($_tokens);

$compiler = $mockista->create('Nette\Latte\Compiler');
$compiler->expects('compile')->once()->with($_tokens)->andReturn($_phpSource);

$filter = new LatteBundle\Bridge\Nette\Templating\LatteFilter($parser, $compiler);

Assert::equal($_phpSource, $filter($_latteSource));

$mockista->assertExpectations();
