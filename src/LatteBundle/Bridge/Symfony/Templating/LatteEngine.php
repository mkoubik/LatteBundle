<?php

namespace LatteBundle\Bridge\Symfony\Templating;

use LatteBundle\Bridge\Nette\Templating\TemplateFactoryInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;

class LatteEngine extends CachingEngine implements EngineInterface
{
	private $templateFactory;

	public function __construct(TemplateNameParserInterface $parser, LoaderInterface $loader, TemplateFactoryInterface $templateFactory)
	{
		parent::__construct($parser, $loader);
		$this->templateFactory = $templateFactory;
	}

	public function render($name, array $parameters = array())
	{
		$storage = $this->load($name);
		$template = $this->templateFactory->createFromStorage($storage);
		if ($template === null) {
			throw new \RuntimeException(sprintf('The template "%s" cannot be rendered.', $name));
		}
		$template->setParameters($parameters);

		ob_start();
		$template->render();
		return ob_get_clean();
	}

	protected function supportsEngine($engine)
	{
		return $engine === 'latte';
	}
}
