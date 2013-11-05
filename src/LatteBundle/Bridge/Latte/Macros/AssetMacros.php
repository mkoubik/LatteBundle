<?php

namespace LatteBundle\Bridge\Latte\Macros;

use Nette\Latte\Macros\MacroSet;
use Nette\Latte\Compiler;
use Nette\Latte\MacroNode;
use Nette\Latte\PhpWriter;

class AssetMacros extends MacroSet
{
	public static function install(Compiler $compiler)
	{
		$me = new static($compiler);

		$me->addMacro('asset', array($me, 'macroAsset'));
	}

	public function macroAsset(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('echo %escape($template->getAssetUrl(%node.args))');
	}
}
