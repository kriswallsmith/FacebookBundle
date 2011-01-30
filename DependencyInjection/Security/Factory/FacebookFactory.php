<?php

namespace FOS\FacebookBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;

class FacebookFactory extends AbstractFactory
{
    protected $authProviderWithoutUserProvider = null;

    public function __construct()
    {
        $this->addOption('cancel_url', '');
        $this->addOption('canvas', 0);
        $this->addOption('display', 'page');
        $this->addOption('fbconnect', 1);
        $this->addOption('permissions', array());
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'fos_facebook';
    }

    protected function getListenerId()
    {
        return 'fos_facebook.security.authentication.listener';
    }

    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        $authProviderId = 'fos_facebook.auth.'.$id;

        // with user provider
        if (isset($config['provider'])) {
            $container
                ->setDefinition($authProviderId, new DefinitionDecorator('fos_facebook.auth'))
                ->setArgument(1, new Reference($userProviderId))
            ;

            return $authProviderId;
        }

        // without user provider
        if (null === $this->authProviderWithoutUserProvider) {
            $this->authProviderWithoutUserProvider = $authProviderId;

            $container->setDefinition($authProviderId, new DefinitionDecorator('fos_facebook.auth'));
        }

        return $this->authProviderWithoutUserProvider;
    }

    protected function createEntryPoint($container, $id, $config, $defaultEntryPointId)
    {
        $options = $this->getOptionsFromConfig($config);

        $entryPointId = 'fos_facebook.security.authentication.entry_point.'.$id;
        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('fos_facebook.security.authentication.entry_point'))
            ->setArgument(1, $options)
        ;

        // set options to container for use by other classes
        $container->setParameter('fos_facebook.options.'.$id, $options);

        return $entryPointId;
    }
}
