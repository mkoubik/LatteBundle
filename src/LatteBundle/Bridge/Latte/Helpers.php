<?php

namespace LatteBundle\Bridge\Latte;

use Symfony\Component\Routing\RouterInterface;
use Nette\Utils\Strings;

class Helpers
{
	private $router;

	public function __construct(RouterInterface $router)
	{
		$this->router = $router;
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
		return $this->router->generate($name, $parameters, $relative ? RouterInterface::RELATIVE_PATH : RouterInterface::ABSOLUTE_PATH);
	}
}
