<?php

namespace LatteBundle\Event;

use Nette\Templating;
use Symfony\Component\EventDispatcher\Event;

class TemplateEvent extends Event
{
	protected $template;

	public function __construct(Templating\ITemplate $template)
	{
		$this->template = $template;
	}

	public function getTemplate()
	{
		return $this->template;
	}
}
