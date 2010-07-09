<?php

namespace Bundle\Kris\FacebookBundle\Controller;

use Symfony\Framework\FoundationBundle\Controller;

class DefaultController extends Controller
{
    /**
     * Renders markup for initializing the Facebook JavaScript API.
     * 
     * @param boolean $status  Whether to fetch login status (defaults to false)
     * @param boolean $xfbml   Whether to parse XFBML tags (defaults to container "facebook.xfbml" parameter)
     * @param array   $session An array of session values
     * 
     * @return Symfony\Components\HttpKernel\Response A response object
     */
    public function initAction($status = false, $xfbml = null, $session = null)
    {
        return $this->render('Kris/FacebookBundle:Default:init', array(
            'app_id'  => $this->container->getParameter('kris.facebook.app_id'),
            'cookie'  => $this->container->getParameter('kris.facebook.cookie'),
            'xfbml'   => $xfbml ?: $this->container->getParameter('kris.facebook.xfbml'),
            'logging' => $this->container->getParameter('kris.facebook.logging'),
            'culture' => $this->container->getParameter('kris.facebook.culture'),
            'status'  => $status,
            'session' => $session,
        ));
    }
}
