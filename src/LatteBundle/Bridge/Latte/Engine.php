<?php

namespace LatteBundle\Bridge\Latte;

use Nette\Latte\Engine as BaseEngine;
use Nette\Latte\Macros as BaseMacros;
use Nette\Latte\Parser;
use Nette\Latte\Compiler;

class Engine extends BaseEngine
{
	/** @var Parser */
	private $parser;

	/** @var Compiler */
	private $compiler;


	public function __construct()
	{
		$this->parser = new Parser;
		$this->compiler = new Compiler;
		$this->compiler->defaultContentType = Compiler::CONTENT_XHTML;

		BaseMacros\CoreMacros::install($this->compiler);
		// $this->compiler->addMacro('cache', new Macros\CacheMacro($this->compiler));
		Macros\UIMacros::install($this->compiler);
		// Macros\FormMacros::install($this->compiler);
	}


	/**
	 * Invokes filter.
	 * @param  string
	 * @return string
	 */
	public function __invoke($s)
	{
		return $this->compiler->compile($this->parser->parse($s));
	}


	/**
	 * @return Parser
	 */
	public function getParser()
	{
		return $this->parser;
	}


	/**
	 * @return Compiler
	 */
	public function getCompiler()
	{
		return $this->compiler;
	}
}
