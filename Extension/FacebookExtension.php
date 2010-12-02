<?php

namespace Bundle\Kris\FacebookBundle\Extension;

use Bundle\FacebookBundle\TokenParser\FacebookTokenParser;

/**
 *
 */
class FacebookExtension extends \Twig_Extension
{
    protected $appId;

    public function __construct($appId)
    {
        $this->appId = $appId;
    }

    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * Returns the token parser instance to add to the existing list.
     *
     * @return array An array of Twig_TokenParser instances
     */
    public function getTokenParsers()
    {
        return array(
            // {% facebook_connect_button %}
            new FacebookTokenParser(),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'facebook';
    }
}
