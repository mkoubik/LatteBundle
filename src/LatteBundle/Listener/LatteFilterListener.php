<?php

namespace LatteBundle\Listener;

use LatteBundle\Bridge\Nette\Templating\LatteFilter;
use LatteBundle\Event\TemplateEvent;

class LatteFilterListener
{
	private $latteFilter;

	public function __construct(LatteFilter $latteFilter)
	{
		$this->latteFilter = $latteFilter;
	}

	public function onCreateTemplate(TemplateEvent $event)
	{
		$template = $event->getTemplate();
		$latteFilter = $this->latteFilter;
		$template->onPrepareFilters[] = function($template) use ($latteFilter) {
			$template->registerFilter($latteFilter);
		};
	}
}
