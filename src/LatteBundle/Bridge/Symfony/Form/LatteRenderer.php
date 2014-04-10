<?php

namespace LatteBundle\Bridge\Symfony\Form;

use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;

class LatteRenderer extends FormRenderer
{
    public function __construct(LatteRendererEngine $engine, CsrfProviderInterface $csrfProvider)
    {
        parent::__construct($engine, $csrfProvider);
    }
}
