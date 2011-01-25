<?php

namespace FOS\FacebookBundle\Security\Firewall;

use FOS\FacebookBundle\Security\Authentication\Token\FacebookUserToken;
use Symfony\Component\HttpKernel\Security\Firewall\FormAuthenticationListener;
use Symfony\Component\HttpFoundation\Request;

/**
 * Facebook authentication listener.
 */
class FacebookListener extends FormAuthenticationListener
{
    protected function attemptAuthentication(Request $request)
    {
        return $this->authenticationManager->authenticate(new FacebookUserToken());
    }
}
