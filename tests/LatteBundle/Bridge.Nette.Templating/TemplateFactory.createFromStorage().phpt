<?php

use LatteBundle\Bridge\Nette\Templating\TemplateFactory;
use Symfony\Component\Templating\Storage;

require_once __DIR__ . '/../bootstrap.php';

$factory = new TemplateFactory();


$storage = new Storage\StringStorage('{hello}{world}');
$template = $factory->createFromStorage($storage);
Assert::type('Nette\Templating\ITemplate', $template);
Assert::equal('{hello}{world}', $template->getSource());


$storage = new Storage\FileStorage(__DIR__ . '/hello.latte');
$template = $factory->createFromStorage($storage);
Assert::type('Nette\Templating\IFileTemplate', $template);
Assert::equal(__DIR__ . '/hello.latte', $template->getFile());
