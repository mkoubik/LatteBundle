<?php

namespace LatteBundle\Bridge\Nette\Latte\Macros;

use Nette\Latte;

class UIMacros extends Latte\Macros\UIMacros
{
	public static function install(Latte\Compiler $compiler)
	{
		$me = new static($compiler);
		$me->addMacro('include', array($me, 'macroInclude'));
		$me->addMacro('includeblock', array($me, 'macroIncludeBlock'));
		$me->addMacro('extends', array($me, 'macroExtends'));
		$me->addMacro('layout', array($me, 'macroExtends'));
		$me->addMacro('block', array($me, 'macroBlock'), array($me, 'macroBlockEnd'));
		$me->addMacro('define', array($me, 'macroBlock'), array($me, 'macroBlockEnd'));
		// $me->addMacro('snippet', array($me, 'macroBlock'), array($me, 'macroBlockEnd'));
		// $me->addMacro('snippetArea', array($me, 'macroBlock'), array($me, 'macroBlockEnd'));
		$me->addMacro('ifset', array($me, 'macroIfset'), '}');

		// $me->addMacro('widget', array($me, 'macroControl')); // deprecated - use control
		// $me->addMacro('control', array($me, 'macroControl'));

		$me->addMacro('href', NULL, NULL, function(Latte\MacroNode $node, Latte\PhpWriter $writer) use ($me) {
			return ' ?> href="<?php ' . $me->macroLink($node, $writer) . ' ?>"<?php ';
		});
		$me->addMacro('plink', array($me, 'macroLink'));
		$me->addMacro('link', array($me, 'macroLink'));
		$me->addMacro('ifCurrent', array($me, 'macroIfCurrent'), '}'); // deprecated; use n:class="$presenter->linkCurrent ? ..."

		// $me->addMacro('contentType', array($me, 'macroContentType'));
		// $me->addMacro('status', array($me, 'macroStatus'));
	}

	/**
	 * {link destination [,] [params]}
	 * {plink destination [,] [params]}
	 * n:href="destination [,] [params]"
	 */
	public function macroLink(Latte\MacroNode $node, Latte\PhpWriter $writer)
	{
		return $writer->write('echo %escape(%modify($_uiMacros->getPath(%node.word, %node.array)))');
	}

	/**
	 * {ifCurrent destination [,] [params]}
	 */
	public function macroIfCurrent(Latte\MacroNode $node, Latte\PhpWriter $writer)
	{
		return $writer->write('if ($_request->getParameter("_route") == %node.word) {');
	}
}
