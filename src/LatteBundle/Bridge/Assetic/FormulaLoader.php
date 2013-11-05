<?php

namespace LatteBundle\Bridge\Assetic;

use Assetic\Factory\Loader\FormulaLoaderInterface;
use Assetic\Factory\Resource\ResourceInterface;

class FormulaLoader implements FormulaLoaderInterface
{
	public function load(ResourceInterface $resource)
	{
		return array();
	}
}
