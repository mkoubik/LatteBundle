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
        $me->addMacro('form_label', array($me, 'macroFormLabel'));
        $me->addMacro('form_widget', array($me, 'macroForm'));
        $me->addMacro('form_errors', array($me, 'macroFormErrors'));

        $me->addMacro('form_theme', '$_latteForms->setTheme(%node.word, %node.array?)');
    }

    public function macroForm(MacroNode $node, PhpWriter $writer)
    {
        $form = $node->tokenizer->fetchWord();
        if ($form === FALSE) {
            throw new CompileException("Missing form name in {{$node->name}}.");
        }
        $block = Strings::startsWith($node->name, 'form_') ? substr($node->name, 5) : $node->name;
        $form = $writer->formatWord($form);
        $vars = $writer->formatArray();
        return $writer->write('echo $_latteForms->' . $block . '(' . $form . ', ' . $vars . ')');
    }

    public function macroFormLabel(MacroNode $node, PhpWriter $writer)
    {
        $form = $node->tokenizer->fetchWord();
        if ($form === FALSE) {
            throw new CompileException("Missing form name in {{$node->name}}.");
        }
        $block = Strings::startsWith($node->name, 'form_') ? substr($node->name, 5) : $node->name;
        $form = $writer->formatWord($form);
        $label = $node->tokenizer->fetchWord();
        $label = $label ? $writer->formatWord($label) : 'null';
        $vars = $writer->formatArray();
        return $writer->write('echo $_latteForms->' . $block . '(' . $form . ', ' . $label . ', ' . $vars . ')');
    }

    public function macroFormErrors(MacroNode $node, PhpWriter $writer)
    {
        $form = $node->tokenizer->fetchWord();
        if ($form === FALSE) {
            throw new CompileException("Missing form name in {{$node->name}}.");
        }
        $block = Strings::startsWith($node->name, 'form_') ? substr($node->name, 5) : $node->name;
        $form = $writer->formatWord($form);
        return $writer->write('echo $_latteForms->' . $block . '(' . $form . ')');
    }
}
