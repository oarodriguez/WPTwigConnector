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

/**
 * Represents a get_header node.
 *
 * @package WPTwigConnector
 * @author Abel Rodríguez
 */
class Header extends Section {
    
    public function compile(\Twig_Compiler $compiler)
    {
        parent::compile($compiler);
        
        $compiler->
            write("wp_head()")
            ->raw(";\n");
    }

    /**
     * Calls the get_header Wordpress action.
     *
     * @param \Twig_Compiler $compiler
     */
    public function do_wp_action(\Twig_Compiler $compiler)
    {
        $compiler->write('do_action( \'get_header\', $name )')->raw(";\n");
    }

}
