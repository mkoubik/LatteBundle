<?php

namespace LatteBundle\Listener;

use LatteBundle\Event\TemplateEvent;
use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;

class GlobalVariablesListener
{
	private $globals;

	public function __construct(GlobalVariables $globals)
	{
		$this->globals = $globals;
	}

	public function onCreateTemplate(TemplateEvent $event)
	{
		$template = $event->getTemplate();
		$template->app = $this->globals;
	}
}
