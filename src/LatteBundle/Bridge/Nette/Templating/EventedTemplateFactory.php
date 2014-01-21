<?php

namespace LatteBundle\Bridge\Nette\Templating;

use LatteBundle\Event\TemplateEvent;
use LatteBundle\LatteEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Templating\Storage\Storage;

class EventedTemplateFactory implements TemplateFactoryInterface
{
	private $factory;

	private $eventDispatcher;

	public function __construct(TemplateFactoryInterface $factory, EventDispatcherInterface $eventDispatcher)
	{
		$this->factory = $factory;
		$this->eventDispatcher = $eventDispatcher;
	}

	public function createFromStorage(Storage $storage)
	{
		$template = $this->factory->createFromStorage($storage);
		if ($template === null) {
			return null;
		}
		$event = new TemplateEvent($template);
		$this->eventDispatcher->dispatch(LatteEvents::CREATE_TEMPLATE, $event);
		return $template;
	}
}
