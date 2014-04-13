<?php

namespace LatteBundle\Bridge\Nette\Latte\Macros;

use Nette\Latte\CompileException;
use Nette\Latte\Compiler;
use Nette\Latte\MacroNode;
use Nette\Latte\PhpWriter;
use Nette\Latte\Macros\MacroSet;
use Nette\Utils\Strings;

class FormMacros extends MacroSet
{
    public static function install(Compiler $compiler)
    {
        $me = new static($compiler);
        $me->addMacro('form', array($me, 'macroForm'));
        $me->addMacro('form_start', array($me, 'macroForm'));
        $me->addMacro('form_end', array($me, 'macroForm'));
        $me->addMacro('form_rest', array($me, 'macroForm'));
        $me->addMacro('form_row', array($me, 'macroForm'));
        $me->addMacro('form_label', array($me, 'macroForm'));
        $me->addMacro('form_widget', array($me, 'macroForm'));
        $me->addMacro('form_errors', array($me, 'macroForm'));

        $me->addMacro('form_theme', '$_latteForms->setTheme(%node.word, %node.array?)');
    }

    public function macroForm(MacroNode $node, PhpWriter $writer)
    {
        $name = $node->tokenizer->fetchWord();
        if ($name === FALSE) {
            throw new CompileException("Missing form name in {{$node->name}}.");
        }
        $node->tokenizer->reset();
        $block = Strings::startsWith($node->name, 'form_') ? substr($node->name, 5) : $node->name;
        return $writer->write('echo $_latteForms->' . $block . '(' . $name . ')');
    }
}
