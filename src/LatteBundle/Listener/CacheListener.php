<?php

namespace LatteBundle\Listener;

use LatteBundle\Event\TemplateEvent;
use Nette\Caching;

class CacheListener
{
	private $cacheStorage;

	public function __construct(Caching\IStorage $cacheStorage)
	{
		$this->cacheStorage = $cacheStorage;
	}

	public function onCreateTemplate(TemplateEvent $event)
	{
		$template = $event->getTemplate();
		$template->setCacheStorage($this->cacheStorage);
	}
}
