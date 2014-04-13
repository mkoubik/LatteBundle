<?php

namespace LatteBundle\Bridge\Symfony\Templating\Helper;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper as BaseHelper;
use Symfony\Component\Form\Extension\Core\View\ChoiceView;

class FormHelper extends BaseHelper
{
    public function getName()
    {
        return 'latteForms';
    }

    /**
     * From Symfony\Bridge\Twig\Extension\FormExtension
     */
    public function isSelectedChoice(ChoiceView $choice, $selectedValue)
    {
        if (is_array($selectedValue)) {
            return false !== array_search($choice->value, $selectedValue, true);
        }

        return $choice->value === $selectedValue;
    }
}
