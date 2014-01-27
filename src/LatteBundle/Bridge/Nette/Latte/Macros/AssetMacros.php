<?php

namespace LatteBundle\Bridge\Nette\Latte\Macros;

use Nette\Latte;

class AssetMacros extends Latte\Macros\MacroSet
{
	public static function install(Latte\Compiler $compiler)
	{
		$me = new static($compiler);

		$me->addMacro('asset', array($me, 'macroAsset'));
	}

	public function macroAsset(Latte\MacroNode $node, Latte\PhpWriter $writer)
	{
		return $writer->write('echo %escape($assets->getUrl(%node.args))');
	}
}
