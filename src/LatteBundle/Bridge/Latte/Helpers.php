<?php

namespace LatteBundle\Bridge\Latte;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Nette\Utils\Strings;

class Helpers implements ContainerAwareInterface
{
	private $container;

	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	public function loader($helper)
	{
		if (method_exists($this, $helper)) {
			return new \Nette\Callback($this, $helper);
		}
	}

	public function getPath($name, $parameters = array())
	{
		if (Strings::startsWith($name, '//')) {
			$name = Strings::substring($name, 2);
			$relative = false;
		} else {
			$relative = true;
		}
		return $this->container->get('router')
			->generate($name, $parameters, $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
	}

	public function getAssetUrl($path, $packageName = null)
	{
		return $this->container->get('templating.helper.assets')
			->getUrl($path, $packageName);
	}

	public function getAssetsVersion($packageName = null)
	{
		return $this->container->get('templating.helper.assets')
			->getVersion($packageName);
	}
}
