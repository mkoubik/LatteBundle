<?php

require_once __DIR__ . '/../bootstrap.php';

$_latteSource = '{$source|noescape}';
$_phpSource = "<?php\n// prolog %A%";

$parser = new Nette\Latte\Parser();
$compiler = new Nette\Latte\Compiler();
Nette\Latte\Macros\CoreMacros::install($compiler);

$filter = new LatteBundle\Bridge\Nette\Templating\LatteFilter($parser, $compiler);

Assert::match($_phpSource, $filter($_latteSource));
