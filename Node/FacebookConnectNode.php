<?php

namespace Bundle\Kris\FacebookBundle\Node;


class FacebookConnectNode extends \Twig_Node
{
    public function compile($compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('printf(')
            ->string($this->getTemplate())
            ->write(', $this->env->getExtension(\'facebook\')->getAppId());')
            ->write("\n")
        ;
    }
    
    protected function getTemplate()
    {
        return <<<EOF
<fb:login-button autologoutlink="true"></fb:login-button>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: %s, status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement('script');
    e.type = 'text/javascript';
    e.src = document.location.protocol +
      '//connect.facebook.net/fr_FR/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
  }());
</script>    
EOF;
    }
}
