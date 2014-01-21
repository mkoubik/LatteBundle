<?php

namespace LatteBundle\Bridge\Nette\Templating;

use Nette\Templating;
use Symfony\Component\Templating\Storage\FileStorage;
use Symfony\Component\Templating\Storage\Storage;
use Symfony\Component\Templating\Storage\StringStorage;

// TODO: chaining?
class TemplateFactory implements TemplateFactoryInterface
{
	public function createFromStorage(Storage $storage)
	{
		if ($storage instanceof StringStorage) {
			return $this->createFromStringStorage($storage);
		}
		if ($storage instanceof FileStorage) {
			return $this->createFromFileStorage($storage);
		}
		return null;
	}

	private function createFromStringStorage(StringStorage $storage)
	{
		$template = new Templating\Template();
		$template->setSource($storage->getContent());
		return $template;
	}

	private function createFromFileStorage(FileStorage $storage)
	{
		$template = new Templating\FileTemplate();
		$template->setFile((string) $storage);
		return $template;
	}
}
