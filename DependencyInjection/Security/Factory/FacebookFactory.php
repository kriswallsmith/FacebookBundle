<?php

namespace FOS\FacebookBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;

class FacebookFactory extends AbstractFactory
{
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

    protected function createAuthProvider(ContainerBuilder $container, $id, $options, $userProviderId)
    {
        $authProviderId = 'fos_facebook.auth';
        if ($userProviderId !== $authProviderId) {
            $provider = $authProviderId.'.'.$id;
            $container
                ->setDefinition($provider, new DefinitionDecorator($authProviderId))
                ->setArgument(1, new Reference($userProviderId))
                ->setArgument(2, new Reference('security.account_checker'))
                ->setArgument(3, $id)
            ;
        } else {
            $provider = $authProviderId;
        }

        return $provider;
    }

    protected function createEntryPoint($container, $id, $config, $defaultEntryPointId)
    {
        $options = $this->getOptionsFromConfig($config);

        $container->getDefinition($defaultEntryPointId);
        $arguments = $container->getArguments();
        $arguments[1]['next'] = $options['check_path'];
        $container->setArguments($arguments);

        return $defaultEntryPointId;
    }

}
