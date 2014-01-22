<?php

namespace LatteBundle;

use LatteBundle\Bridge\Symfony\Templating\LatteEngine as BaseEngine;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

class LatteEngine extends BaseEngine implements EngineInterface
{
	/**
	* Renders a view and returns a Response.
	*
	* @param string   $view       The view name
	* @param array    $parameters An array of parameters to pass to the view
	* @param Response $response   A Response instance
	*
	* @return Response A Response instance
	*/
	public function renderResponse($view, array $parameters = array(), Response $response = null)
	{
		if (null === $response) {
			$response = new Response();
		}

		$response->setContent($this->render($view, $parameters));

		return $response;
	}
}
