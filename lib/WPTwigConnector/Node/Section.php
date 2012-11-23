<?php

/*
 * This file is part of WPTwigConnector.
 *
 * Copyright (c) 2012, Abel Rodríguez
 * All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPTwigConnector\Node;

use \Twig_Node;
use \Twig_Compiler;

/**
 * Represents a get_section node.
 * 
 * @package WPTwigConnector
 * @author Abel Rodríguez
 */
class Section extends Twig_Node {

    /**
     * @param $slug \Twig_Node_Expression
     * @param $name
     * @param $kind
     * @param $lineno
     * @param $tag
     */
    function __construct($slug, $name, $kind, $lineno, $tag = null)
    {
        parent::__construct(array('slug' => $slug, 'name' => $name), array('kind' => $kind), $lineno, $tag);
    }

    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        if ($this->getNode('slug') instanceof \Twig_Node_Expression) {
            // @formatter:off
            $compiler
                ->write('$slug = ')
                ->subcompile($this->getNode('slug'))
                ->raw(";\n");
        } else {
            $compiler 
                ->write('$slug = \'' . $this->getAttribute('kind') . '\'')
                ->raw(";\n");
        }

        if ($this->getNode('name') instanceof \Twig_Node_Expression) {
            $compiler
                ->write('$name = ')
                ->subcompile($this->getNode('name'))
                ->raw(";\n");
        } else {
            $compiler
            ->write('$name = null')
            ->raw(";\n");
        }
        
        $this->do_wp_action($compiler);
        
        // @formatter:off
        $compiler
            ->write('$section_name = isset($name) ? "{$slug}-{$name}.php" : "{$slug}.php"')
            ->raw(";\n");

        // @formatter:off
        $compiler
            ->write("try {\n")
            ->indent();

        // @formatter:off
        $compiler
            ->write("\$this->env->loadTemplate(")
            ->raw('$section_name')
            ->raw(")");
        
        // @formatter:off
        $compiler
            ->raw('->display(')
            ->raw('$context')
            ->raw(");\n");

        // @formatter:off
        $compiler
            ->outdent()
            ->write("} catch (Twig_Error_Loader \$e) {\n")
            ->indent()
            ->write("// ignore missing template\n")
            ->outdent()
            ->write("}\n\n");
    }

    /**
     * Calls the Worpress action corresponding to the template part being
     * included.
     * 
     * @param \Twig_Compiler $compiler 
     */
    public function do_wp_action(\Twig_Compiler $compiler)
    {
        // @formatter:off
        $compiler
            ->write('do_action( "get_template_part_{$slug}", $slug, $name )')
            ->raw(";\n");
    }

}
