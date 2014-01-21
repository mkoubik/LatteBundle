<?php

namespace LatteBundle\Bridge\Nette\Latte;

use Nette\Latte;

class CompilerFactory
{
	public function create()
	{
		$compiler = new Latte\Compiler();
		// TODO: install macros
		return $compiler;
	}
}
