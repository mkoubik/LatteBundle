<?php

namespace LatteBundle\Bridge\Symfony\Templating\Helper;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper as BaseHelper;

class FormHelper extends BaseHelper
{
    public function getName()
    {
        return 'latteForms';
    }
}
