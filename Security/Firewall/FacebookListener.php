<?php

namespace FOS\FacebookBundle\Security\Firewall;

use FOS\FacebookBundle\Security\Authentication\Token\FacebookUserToken;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;

use Symfony\Component\HttpFoundation\Request;

/**
 * Facebook authentication listener.
 */
class FacebookListener extends AbstractAuthenticationListener
{
    protected function attemptAuthentication(Request $request)
    {
        return $this->authenticationManager->authenticate(new FacebookUserToken());
    }
}
