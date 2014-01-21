<?php

use LatteBundle\Event\TemplateEvent;
use LatteBundle\Listener\LatteFilterListener;
use Nette\Templating\Template;

require_once __DIR__ . '/../bootstrap.php';

$_latteSource = 'Hello {$name}!';
$_name = 'world';
$_html = 'Hello world!';

$parser = new Nette\Latte\Parser();
$compiler = new Nette\Latte\Compiler();
Nette\Latte\Macros\CoreMacros::install($compiler);
$filter = new LatteBundle\Bridge\Nette\Templating\LatteFilter($parser, $compiler);
$template = new Template();
$template->setSource($_latteSource);
$event = new TemplateEvent($template);

$listener = new LatteFilterListener($filter);

$listener->onCreateTemplate($event);

ob_start();
$template->name = $_name;
$template->render();
$html = ob_get_clean();

Assert::equal($_html, $html);
