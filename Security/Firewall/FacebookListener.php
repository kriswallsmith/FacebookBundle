<?php

namespace Bundle\Kris\FacebookBundle\Security\Firewall;


use Symfony\Component\HttpKernel\Security\Firewall\PreAuthenticatedListener;
use Symfony\Component\HttpFoundation\Request;

/**
 * Facebook authentication listener.
 *
 */
class FacebookListener extends PreAuthenticatedListener
{
    protected function getPreAuthenticatedData(Request $request)
    {
        // array(id_user, query_string)
        return array('_facebook_', '_no_pass_');
    }
}
