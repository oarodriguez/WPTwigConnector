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

namespace WPTwigConnector\Extension;

use \Twig_Extension;

/**
 * Contains all the globals, functions, tags, filters and tests to use in
 * Wordpress themes.
 *
 * @package WPTwigConnector
 * @author Abel Rodríguez
 */
class Wordpress extends Twig_Extension
{
    /**
     * Returns an array of global variables used in Wordpress themes.
     *
     * @return array An array of variables
     */
    public function getGlobals()
    {
        global $post, $page, $paged;

        // @formatter:off
        return array(
            'post' => $post,
            'page' => $page,
            'paged' => $paged
        );   
    }
    
    /**
     * Returns the functions to use in Wordpress themes.
     * 
     * @return array An array of (name => Twig_Function_Function) instances
     */
    public function getFunctions()
    {
        // @formatter:off
        return array(
            'the_title' => new \Twig_Function_Function('the_title'),
            'language_attributes' => new \Twig_Function_Function('language_attributes'),
            'bloginfo' => new \Twig_Function_Function('bloginfo'),
            
            'style_url' => new \Twig_Function_Function("\WPTwigConnector\Extension\style_url"),
            'less_url' => new \Twig_Function_Function("\WPTwigConnector\Extension\less_url"),
            'script_url' => new \Twig_Function_Function("\WPTwigConnector\Extension\script_url")
        );  
    }

    /**
     * Returns the token parsers to use in Wordpress themes.s
     *
     * @return array An array of Twig_TokenParser instances
     */
    public function getTokenParsers()
    {
        // @formatter:off
        return array(
            new \WPTwigConnector\TokenParser\Header()
        );
    }
    
    public function getName()
    {
        return "wordpress";
    }
    
}


/**
 * Add a stylesheet to the template.
 *  
 * @param string $filename The filename of the stylesheet.
 * @param boolean $less Whether or not load the stylesheets from the /less directory. 
 */
function style_url($filename, $less = false)
{
    $style_dir = ($less === true) ? '/less/' : '/css/';
    return \get_template_directory_uri() . $style_dir . $filename;
}

/**
 * Add a LESS stylesheet to the template.
 *  
 * @param string $filename The filename of the stylesheet. 
 */
function less_url($filename)
{
    return \get_template_directory_uri() . '/less/' . $filename;
}


/**
 * Add a script to the template.
 *  
 * @param string $filename The filename of the script.
 */
function script_url($filename)
{
    return \get_template_directory_uri() . '/js/' . $filename;
}
