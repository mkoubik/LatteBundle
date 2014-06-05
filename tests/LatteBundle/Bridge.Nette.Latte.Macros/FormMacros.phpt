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


$factory = Symfony\Component\Form\Forms::createFormFactory();


$form1 = $factory->createBuilder()
    ->add('create', 'submit', array(
        'label' => 'Create',
        'attr' => array('class' => 'button'),
    ))
    ->getForm();

$html = $engine->render('TestingBundle:test:formMacros.html.latte', array(
    'form1' => $form1->createView(),
));
Assert::matchFile(__DIR__ . '/expected/formMacros.html', $html);
