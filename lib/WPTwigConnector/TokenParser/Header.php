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

namespace WPTwigConnector\TokenParser;

use \Twig_TokenParser_Include;
use WPTwigConnector\Node;

/**
 * Provides support for get_header tag. It's used to include template parts
 * used as headers in the same way as Worpress functions.
 *
 * <pre>
 *     {% header name="header_name" %}
 *     Body
 * </pre>
 *
 * @package WPTwigConnector
 * @author Abel Rodríguez
 */
class Header extends Section {

    /**
     * Parses a token and returns a node.
     *
     * @param Twig_Token $token A Twig_Token instance
     * @return Twig_NodeInterface A Twig_NodeInterface instance
     */
    public function parse(\Twig_Token $token)
    {
        $stream = $this->parser->getStream();

        if ($stream->test(\Twig_Token::NAME_TYPE, 'default')) {
            $name = $this->parser->getExpressionParser()->parseExpression();
        } else {
            $stream->expect(\Twig_Token::NAME_TYPE, 'name');
            $stream->expect(\Twig_Token::OPERATOR_TYPE, '=');
            $name = $this->parser->getExpressionParser()->parseExpression();
        }

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        return new Node\Header(null, $name, 'header', $token->getLine(), $this->getTag());
    }

    public function getTag()
    {
        return 'header';
    }

}
