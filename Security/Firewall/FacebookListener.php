<?php

namespace Bundle\FOS\FacebookBundle\Security\Firewall;

use Bundle\FOS\FacebookBundle\Security\Authentication\Token\FacebookUserToken;
use Symfony\Component\HttpKernel\Security\Firewall\FormAuthenticationListener;

/**
 * Facebook authentication listener.
 */
class FacebookListener extends FormAuthenticationListener
{
    protected function attemptAuthentication($request)
    {
        return $this->authenticationManager->authenticate(new FacebookUserToken());
    }
}