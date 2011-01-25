<?php

namespace FOS\FacebookBundle\Security\Authentication\Token;

use Symfony\Component\Security\Authentication\Token\Token;

class FacebookUserToken extends Token
{
    public function __construct($uid = '', array $roles = array())
    {
        parent::__construct($roles);

        $this->setUser($uid);

        if (!empty($uid)) {
            $this->authenticated = true;
        }
    }
}