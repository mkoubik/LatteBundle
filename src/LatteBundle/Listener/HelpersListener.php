<?php

namespace LatteBundle\Listener;

use LatteBundle\Event\TemplateEvent;

class HelpersListener
{
	public function onCreateTemplate(TemplateEvent $event)
	{
		$template = $event->getTemplate();
        $template->registerHelperLoader('Nette\Templating\Helpers::loader');
        $template->registerHelperLoader('LatteBundle\Bridge\Nette\Templating\Helpers::loader');
	}
}
