<?php

namespace Bundle\FOS\FacebookBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Exception\AuthenticationException;
use Bundle\FOS\FacebookBundle\Security\Authentication\Token\FacebookUserToken;
use \Facebook;
use Symfony\Component\Security\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Authentication\Provider\AuthenticationProviderInterface;

class FacebookProvider implements AuthenticationProviderInterface
{
    /**
		 * @var \Facebook
     */
    protected $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
    }

    public function authenticate(TokenInterface $token)
    {
        if (!$this->supports($token)) {
            return null;
        }

        try {
            if ($uid = $this->facebook->getUser()) {
                return $this->createAuthenticatedToken($uid);
            }
        } catch (\Exception $failed) {
            if ($failed instanceof AuthenticationException) {
                throw $failed;
            }

            throw new AuthenticationException($failed->getMessage(), $failed->getCode(), $failed);
        }

        throw new AuthenticationException('The Facebook user could not be retrieved from the session.');
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof FacebookUserToken;
    }

    protected function createAuthenticatedToken($uid)
    {
        return new FacebookUserToken($uid);
    }
}