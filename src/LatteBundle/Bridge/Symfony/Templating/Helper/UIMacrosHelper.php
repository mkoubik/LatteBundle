<?php

namespace LatteBundle\Bridge\Symfony\Templating\Helper;

use Nette\Utils\Strings;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Templating\Helper\Helper;

class UIMacrosHelper extends Helper
{
	private $generator;

	public function __construct(UrlGeneratorInterface $generator)
	{
		$this->generator = $generator;
	}

	public function getName()
	{
		return 'uiMacros';
	}

	public function getPath($name, $parameters = array())
	{
		if (Strings::startsWith($name, '//')) {
			$name = Strings::substring($name, 2);
			$relative = false;
		} else {
			$relative = true;
		}
		return $this->generator
			->generate($name, $parameters, $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
	}
}
