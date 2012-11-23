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

use \Twig_TokenParser;
use WPTwigConnector\Node;

/**
 * Provides support for get_section tag. It's used to include the rendered
 * content from other Twig templates in the same way as Worpress functions.
 *
 * <pre>
 *     {% get_section slug="content" name="single" %}
 *     Body
 * </pre>
 *
 * @package WPTwigConnector
 * @author Abel Rodríguez
 */
class Section extends Twig_TokenParser {

    /**
     * Parses a token and returns a node.
     *
     * @param Twig_Token $token A Twig_Token instance
     * @return Twig_NodeInterface A Twig_NodeInterface instance
     */
    public function parse(\Twig_Token $token)
    {
        $stream = $this->parser->getStream();

        $stream->expect(\Twig_Token::NAME_TYPE, 'slug');
        $stream->expect(\Twig_Token::OPERATOR_TYPE, '=');
        $slug = $this->parser->getExpressionParser()->parseExpression();

        $name = null;
        if ($stream->test(\Twig_Token::NAME_TYPE, 'name')) {
            $stream->next();
            $stream->expect(\Twig_Token::OPERATOR_TYPE, '=');
            $name = $this->parser->getExpressionParser()->parseExpression();
        }

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new Node\Section($slug, $name, null, $token->getLine(), $this->getTag());
    }

    public function getTag()
    {
        return "section";
    }

}
