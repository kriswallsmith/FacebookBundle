<?php

namespace Bundle\Kris\FacebookBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class FacebookHelper extends Helper
{
    const FORMAT = <<<HTML
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() { FB.init(%s); };
  (function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + %s;
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
  })();
</script>

HTML;

    protected $appId;
    protected $cookie;
    protected $logging;
    protected $culture;

    public function __construct($appId, $cookie = false, $logging = true, $culture = 'en_US')
    {
        $this->appId = $appId;
        $this->cookie = $cookie;
        $this->logging = $logging;
        $this->culture = $culture;
    }

    /**
     * Returns the HTML necessary for initializing the JavaScript SDK.
     * 
     * Available options:
     * 
     *  * xfbml
     *  * session
     *  * status
     *  * cookie
     *  * logging
     *  * culture
     * 
     * @param array $options An array of initialization options
     * 
     * @return string An HTML string
     */
    public function initialize($options = array())
    {
        // apply defaults
        $options += array(
            'xfbml'   => false,
            'session' => null,
            'status'  => false,
            'cookie'  => null,
            'logging' => null,
            'culture' => null,
        );

        return vsprintf(static::FORMAT, array_map('json_encode', array(
            array(
                'appId'   => $this->appId,
                'xfbml'   => $options['xfbml'],
                'session' => $options['session'],
                'status'  => $options['status'],
                'cookie'  => $options['cookie'] ?: $this->cookie,
                'logging' => $options['logging'] ?: $this->logging,
            ),
            '//connect.facebook.net/'.($options['culture'] ?: $this->culture).'/all.js',
        )));
    }

    public function getName()
    {
        return 'facebook';
    }
}
