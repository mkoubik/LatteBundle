<?php

namespace LatteBundle\Listener;

use LatteBundle\Event\TemplateEvent;
use Symfony\Component\Templating\Helper\HelperInterface;

class HelperServicesListener
{
	private $helpers = array();

	public function addHelper(HelperInterface $helper, $name = null)
	{
		if ($name === null) {
			$name = $helper->getName();
		}
		$this->helpers[$name] = $helper;
	}

	public function onCreateTemplate(TemplateEvent $event)
	{
		$template = $event->getTemplate();
		foreach ($this->helpers as $name => $helper) {
			$template->{'_' . $name} = $helper;
		}
	}
}
