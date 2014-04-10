<?php

namespace LatteBundle\Bridge\Nette\Templating;

class Helpers
{
    public static function loader($helper)
    {
        if (method_exists(__CLASS__, $helper)) {
            return array(__CLASS__, $helper);
        }
    }

    // from Symfony\Component\Form\FormRenderer
    public static function humanize($text)
    {
        return ucfirst(trim(strtolower(preg_replace(array('/([A-Z])/', '/[_\s]+/'), array('_$1', ' '), $text))));
    }
}
