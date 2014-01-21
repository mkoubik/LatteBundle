<?php

namespace LatteBundle\Event;

use Nette\Templating\ITemplate as TemplateInterface;
use Symfony\Component\EventDispatcher\Event;

class TemplateEvent extends Event
{
	protected $template;

	public function __construct(TemplateInterface $template)
	{
		$this->template = $template;
	}

	public function getTemplate()
	{
		return $this->template;
	}
}
