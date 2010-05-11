<?php

namespace Bundle\FacebookBundle\Controller;

use Symfony\Framework\WebBundle\Controller;

class DefaultController extends Controller
{
    public function initAction()
    {
        return $this->render('FacebookBundle:Default:init', array(
            'app_id'  => $this->container->getParameter('facebook.app_id'),
            'status'  => true,
            'cookie'  => $this->container->getParameter('facebook.cookie'),
            'xfbml'   => $this->container->getParameter('facebook.xfbml'),
            'culture' => $this->container->getParameter('facebook.culture'),
        ));
    }
}
