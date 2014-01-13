<?php

namespace LatteBundle\Bridge\Nette\Templating;

use Nette\Latte;

class LatteFilter
{
	/** @var Latte\Parser */
	private $parser;

	/** @var Latte\Compiler */
	private $compiler;

	public function __construct(Latte\Parser $parser, Latte\Compiler $compiler)
	{
		$this->parser = $parser;
		$this->compiler = $compiler;
	}

	/**
	 * Runs latte filter.
	 * @param  string $str latte source
	 * @return string php code
	 */
	public function __invoke($str)
	{
		$tokens = $this->parser->parse($str);
		return $this->compiler->compile($tokens);
	}
}
