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

/**
 * The environment to use Twig templates instead normal Wordpress templates.
 *
 * @param array $options The Twig environment options
 * @package WPTwigConnector
 * @author Abel Rodríguez
 */
class Environment extends Twig_Environment
{
    public function __construct($options = array())
    {
        // Here we tell Twig to search template files by priority, first in
        // STYLESHEETPATH and later in TEMPLATEPATH, to support child themes.
        // @formatter:off
        $search_dirs = array(
            \STYLESHEETPATH, \STYLESHEETPATH . '/widgets/', \STYLESHEETPATH . '/admin/', 
            \TEMPLATEPATH, \TEMPLATEPATH . '/widgets/', \TEMPLATEPATH . '/admin/',
            dirname(__DIR__) . '/../layouts/'
        );

        $loader = new \Twig_Loader_Filesystem($search_dirs);
        parent::__construct($loader, $options);
        
        $this->addExtension(new \WPTwigConnector\Extension\Wordpress());
    }
}
