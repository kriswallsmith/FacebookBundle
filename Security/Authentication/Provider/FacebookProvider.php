<?php

namespace FOS\FacebookBundle\Security\Authentication\Provider;

use Symfony\Component\Security\User\AccountInterface;
use Symfony\Component\Security\User\AccountCheckerInterface;
use Symfony\Component\Security\User\UserProviderInterface;
use Symfony\Component\Security\Exception\AuthenticationException;
use Symfony\Component\Security\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Authentication\Provider\AuthenticationProviderInterface;

use FOS\FacebookBundle\Security\Authentication\Token\FacebookUserToken;
use \Facebook;

class FacebookProvider implements AuthenticationProviderInterface
{
    /**
     * @var \Facebook
     */
    protected $facebook;
    protected $userProvider;
    protected $accountChecker;

    public function __construct(Facebook $facebook, UserProviderInterface $userProvider = null, AccountCheckerInterface $accountChecker = null)
    {
        if (null !== $userProvider && null === $accountChecker) {
            throw new \InvalidArgumentException('$accountChecker cannot be null, if $userProvider is not null.');
        }

        $this->facebook = $facebook;
        $this->userProvider = $userProvider;
        $this->accountChecker = $accountChecker;
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
        if (null === $this->userProvider) {
            return new FacebookUserToken($uid);
        }

        $user = $this->userProvider->loadUserByUsername($uid);
        if (!$user instanceof AccountInterface) {
            throw new \RuntimeException('User provider did not return an implementation of account interface.');
        }

        $this->accountChecker->checkPreAuth($user);
        $this->accountChecker->checkPostAuth($user);

        return new FacebookUserToken($user, $user->getRoles());
    }
}
