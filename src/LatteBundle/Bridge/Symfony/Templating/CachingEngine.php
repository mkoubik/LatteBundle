<?php

namespace LatteBundle\Bridge\Symfony\Templating;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Templating\Loader\LoaderInterface;

abstract class CachingEngine implements EngineInterface
{
	private $cache = array();

	private $parser;

	private $loader;

	public function __construct(TemplateNameParserInterface $parser, LoaderInterface $loader)
	{
		$this->parser = $parser;
		$this->loader = $loader;
	}

	public function supports($name)
	{
		$template = $this->parser->parse($name);
		$engine = $template->get('engine');
		return $this->supportsEngine($engine);
	}

	protected function load($name)
	{
		$template = $this->parser->parse($name);

		$key = $template->getLogicalName();
		if (isset($this->cache[$key])) {
			return $this->cache[$key];
		}

		$storage = $this->loader->load($template);

		if ($storage === false) {
			throw new \InvalidArgumentException(sprintf('The template "%s" does not exist.', $template));
		}

		return $this->cache[$key] = $storage;
	}

	protected function supportsEngine($engine)
	{
		return false;
	}
}
