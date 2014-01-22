<?php

namespace LatteBundle\Bridge\Nette\Latte;

use Nette\Latte;

class CompilerFactory
{
	public function create()
	{
		$compiler = new Latte\Compiler();
		Latte\Macros\CoreMacros::install($compiler);
		return $compiler;
	}
}
