<?php

namespace LatteBundle\Bridge\Nette\Latte;

use LatteBundle\Bridge\Nette\Latte\Macros;
use Nette\Latte;

class CompilerFactory
{
	public function create()
	{
		$compiler = new Latte\Compiler();
		Latte\Macros\CoreMacros::install($compiler);
		Macros\UIMacros::install($compiler);
        Macros\AssetMacros::install($compiler);
        Macros\FormMacros::install($compiler);
		return $compiler;
	}
}
