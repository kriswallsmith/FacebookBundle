<?php


namespace Bundle\Kris\FacebookBundle\TokenParser;

use Bundle\FacebookBundle\Node\FacebookConnectNode;

class FacebookTokenParser extends \Twig_TokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param Twig_Token $token A Twig_Token instance
     *
     * @return Twig_NodeInterface A Twig_NodeInterface instance
     */
    public function parse(\Twig_Token $token)
    {
        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

        return new FaceBookConnectNode(array(), array(), $token->getLine());
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @param string The tag name
     */
    public function getTag()
    {
        return 'facebook_connect_button';
    }
}
