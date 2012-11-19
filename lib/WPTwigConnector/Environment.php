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

namespace WPTwigConnector;

use \Twig_Environment;
use \Twig_Function_Function;

/**
 * The environment to use Twig templates instead normal Wordpress templates.
 *
 * @package TwigConnector
 * @author Abel Rodríguez
 */
class Environment extends Twig_Environment {

    public function __construct($options = array())
    {
        // Here we tell Twig to search template files by priority, first in
        // STYLESHEETPATH and later in TEMPLATEPATH, to support child themes.
        // @formatter:off
        $search_dirs = array(\STYLESHEETPATH, \STYLESHEETPATH . '/widgets/',
            \TEMPLATEPATH, \TEMPLATEPATH . '/widgets/');

        $loader = new \Twig_Loader_Filesystem($search_dirs);
        parent::__construct($loader, $options);

        $this->register_functions_and_globals();
    }

    /**
     * Defines and register the functions that will be available in the
     * templates.
     */
    protected function register_functions_and_globals()
    {
        global $post, $page, $paged;

        // @formatter:off
        $globals = array(
            'post' => $post,
            'page' => $page,
            'paged' => $paged
        );
        // @formatter:off
        $functions = array(
            'the_title' => new Twig_Function_Function('the_title'),
            'language_attributes' => new Twig_Function_Function('language_attributes'),
            'bloginfo' => new Twig_Function_Function('bloginfo'),
            
            'style_url' => new Twig_Function_Function("\WPTwigConnector\style_url"),
            'less_url' => new Twig_Function_Function("\WPTwigConnector\less_url"),
            'script_url' => new Twig_Function_Function("\WPTwigConnector\script_url")
        );
        
        foreach ($globals as $name => $global) {
            $this->addGlobal($name, $global);
        }

        foreach ($functions as $name => $function) {
            $this->addFunction($name, $function);
        }
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
