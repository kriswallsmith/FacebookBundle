<?php

namespace Bundle\Kris\FacebookBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Templating\Engine;

class FacebookHelper extends Helper
{
    protected $templating;
    protected $appId;
    protected $cookie;
    protected $logging;
    protected $culture;

    public function __construct(Engine $templating, $appId, $cookie = false, $logging = true, $culture = 'en_US')
    {
        $this->templating = $templating;
        $this->appId      = $appId;
        $this->cookie     = $cookie;
        $this->logging    = $logging;
        $this->culture    = $culture;
    }

    /**
     * Returns the HTML necessary for initializing the JavaScript SDK.
     *
     * The default template includes the following parameters:
     *
     *  * appId
     *  * xfbml
     *  * session
     *  * status
     *  * cookie
     *  * logging
     *  * culture
     *
     * @param array  $parameters An array of parameters for the initialization template
     * @param string $name       A template name
     *
     * @return string An HTML string
     */
    public function initialize($parameters = array(), $name = 'Kris\\FacebookBundle::initialize.php')
    {
        return $this->templating->render($name, $parameters + array(
            'appId'   => $this->appId,
            'xfbml'   => false,
            'session' => null,
            'status'  => false,
            'cookie'  => $this->cookie,
            'logging' => $this->logging,
            'culture' => $this->culture,
        ));
    }

    /**
     * @codeCoverageIgnore
     */
    public function getName()
    {
        return 'facebook';
    }
}
