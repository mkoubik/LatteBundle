<?php

namespace LatteBundle\Bridge\Symfony\Form;

use Symfony\Component\Form\Extension\Templating\TemplatingRendererEngine;
use Symfony\Component\Form\FormView;
use Symfony\Component\Templating\EngineInterface;

class LatteRendererEngine extends TemplatingRendererEngine
{
    private $engine;

    // TODO: remove (when $engine is protected in TemplatingRendererEngine)
    public function __construct(EngineInterface $engine, array $defaultThemes = array())
    {
        parent::__construct($engine, $defaultThemes);

        $this->engine = $engine;
    }

    // TODO: remove (when $engine is protected in TemplatingRendererEngine)
    public function renderBlock(FormView $view, $resource, $blockName, array $variables = array())
    {
        return trim($this->engine->render($resource, $variables));
    }

    protected function loadResourceFromTheme($cacheKey, $blockName, $theme)
    {
        if ($this->engine->exists($templateName = $theme.':'.$blockName.'.html.latte')) {
            $this->resources[$cacheKey][$blockName] = $templateName;

            return true;
        }

        return false;
    }
}
