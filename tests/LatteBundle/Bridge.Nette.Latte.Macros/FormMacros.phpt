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


$form1 = $factory->createBuilder('form', null, array(
        'attr' => array('class' => 'inline-form'),
    ))
    ->add('create', 'submit', array(
        'label' => 'Create',
        'attr' => array('class' => 'button'),
    ))
    ->getForm();

$form2 = $factory->createBuilder()
    ->add('image', 'file', array(
        'label' => 'Image',
        'required' => false,
        'attr' => array(
            'class' => '',
            'accept' => 'image/*',
        ),
    ))
    ->add('email', 'email', array(
        'label' => 'E-mail',
        'attr' => array('class' => 'form-control'),
        'max_length' => 255,
    ))
    ->getForm();


$html = $engine->render('TestingBundle:test:formMacros.html.latte', array(
    'form1' => $form1->createView(),
    'form2' => $form2->createView(),
));
Assert::matchFile(__DIR__ . '/expected/formMacros.html', $html);
