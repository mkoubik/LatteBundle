<?php

namespace LatteBundle\Bridge\Nette\Templating;

use Nette\Templating;
use Symfony\Component\Templating\Storage\Storage;

interface TemplateFactoryInterface
{
	/**
	 * @param  Storage $storage
	 * @return Templating\ITemplate|NULL
	 */
	public function createFromStorage(Storage $storage);
}
