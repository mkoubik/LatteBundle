<?php

namespace LatteBundle\Bridge;

use symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Component\Templating\Storage\Storage;
use Symfony\Component\Templating\Storage\FileStorage;
use Symfony\Component\Templating\Storage\StringStorage;
use Nette\Latte\Engine as Latte;
use Nette\Caching\Storages\PhpFileStorage;
use Nette\Caching\Storages\FileJournal;
use LatteBundle\Bridge\Latte\Helpers;
use LatteBundle\LatteEvents;
use LatteBundle\Event\CreateTemplateEvent;

class LatteEngine implements EngineInterface
{
	protected $parser;
	protected $loader;
	protected $latte;
	protected $helpers;
	protected $eventDispatcher;
	protected $cacheDir;

	protected $cache;

	public function __construct(TemplateNameParserInterface $parser, LoaderInterface $loader, Latte $latte, Helpers $helpers, EventDispatcherInterface $eventDispatcher)
	{
		$this->parser = $parser;
		$this->loader = $loader;
		$this->latte = $latte;
		$this->helpers = $helpers;
		$this->eventDispatcher = $eventDispatcher;

		$this->cache = array();
	}

	public function render($name, array $parameters = array())
	{
		$storage = $this->load($name);
		$key = md5(serialize($storage));

		if (false === $content = $this->evaluate($storage, $parameters)) {
			throw new \RuntimeException(sprintf('The template "%s" cannot be rendered.', $this->parser->parse($name)));
		}

		return $content;
	}

	public function exists($name)
	{
		try {
			$this->load($name);
		} catch (\InvalidArgumentException $e) {
			return false;
		}

		return true;
	}

	public function supports($name)
	{
		$template = $this->parser->parse($name);

		return 'latte' === $template->get('engine');
	}

	public function setCacheDir($cacheDir)
	{
		if (false === @mkdir($cacheDir, 0777, true) && !is_dir($cacheDir)) {
			throw new \RuntimeException(sprintf("Unable to create the cache directory (%s).", $cacheDir));
		}
		$this->cacheDir = $cacheDir;
	}

	protected function load($name)
	{
		$template = $this->parser->parse($name);

		$key = $template->getLogicalName();
		if (isset($this->cache[$key])) {
			return $this->cache[$key];
		}

		$storage = $this->loader->load($template);

		if (false === $storage) {
			throw new \InvalidArgumentException(sprintf('The template "%s" does not exist.', $template));
		}

		return $this->cache[$key] = $storage;
	}

	protected function evaluate(Storage $template, array $parameters = array())
	{
		$__template__ = $template;

		if (isset($parameters['__template__'])) {
			throw new \InvalidArgumentException('Invalid parameter (__template__)');
		}

		if ($__template__ instanceof FileStorage) {
			$template = new \Nette\Templating\FileTemplate($__template__);
			$latte = $this->latte;
			$template->onPrepareFilters[] = function($template) use ($latte) {
				$template->registerFilter($latte);
			};
			$template->registerHelperLoader('Nette\Templating\Helpers::loader');
			$template->registerHelperLoader(new \Nette\Callback($this->helpers, 'loader'));
			if ($this->cacheDir) {
				$storage = new PhpFileStorage($this->cacheDir, new FileJournal($this->cacheDir));
				$template->setCacheStorage($storage);
			}
			$this->eventDispatcher->dispatch(LatteEvents::CREATE_TEMPLATE, new CreateTemplateEvent($template));
			$template->setParameters($parameters);
			ob_start();
			$template->render();

			return ob_get_clean();
		} elseif ($__template__ instanceof StringStorage) {
			$template = new \Nette\Templating\Template();
			$template->setSource($__template__);
			$latte = $this->latte;
			$template->onPrepareFilters[] = function($template) use ($latte) {
				$template->registerFilter($latte);
			};
			$template->registerHelperLoader('Nette\Templating\Helpers::loader');
			$template->registerHelperLoader(new \Nette\Callback($this->helpers, 'loader'));
			if ($this->cacheDir) {
				$storage = new PhpFileStorage($this->cacheDir, new FileJournal($this->cacheDir));
				$template->setCacheStorage($storage);
			}
			$this->eventDispatcher->dispatch(LatteEvents::CREATE_TEMPLATE, new CreateTemplateEvent($template));
			$template->setParameters($parameters);
			ob_start();
			$template->render();

			return ob_get_clean();
		}

		return false;
	}
}
