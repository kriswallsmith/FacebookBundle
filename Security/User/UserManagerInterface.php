<?php

namespace FOS\FacebookBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;

interface UserManagerInterface extends UserProviderInterface
{
    public function createUserFromUid($uid);
}
