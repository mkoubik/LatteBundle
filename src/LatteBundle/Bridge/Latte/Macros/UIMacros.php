<?php

namespace LatteBundle\Bridge\Latte\Macros;

use Nette\Latte\Macros as BaseMacros;
use Nette\Latte\MacroNode;
use Nette\Latte\PhpWriter;

class UIMacros extends BaseMacros\UIMacros
{
	/**
	 * {link destination [,] [params]}
	 * {plink destination [,] [params]}
	 * n:href="destination [,] [params]"
	 */
	public function macroLink(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('echo %escape(%modify($template->getPath(%node.word, %node.array)))');
	}
}
