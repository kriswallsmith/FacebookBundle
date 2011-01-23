<?php

namespace FOS\FacebookBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class FacebookFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProviderId, $defaultEntryPoint)
    {
        $providerId = 'fos_facebook.auth';
        if ($userProviderId !== $providerId) {
            $provider = clone $container->getDefinition($providerId);

            $arguments = $provider->getArguments();
            $arguments[] = new Reference($userProviderId);
            $arguments[] = new Reference('security.account_checker');

            $provider->setArguments($arguments);

            $providerId.= '.'.$id;
            $container->setDefinition($providerId, $provider);
        }

        $listenerId = 'fos_facebook.security.authentication.listener';
        $listener = clone $container->getDefinition($listenerId);

        $arguments = $listener->getArguments();
        $arguments[1] = new Reference($providerId);

        if (is_array($config)) {
            $options = $container->getParameter('fos_facebook.security.authentication.options');
            $options = array_merge($options, $config);
            $arguments[2] = $options;
        }

        $listener->setArguments($arguments);

        $listenerId.= '.'.$id;
        $container->setDefinition($listenerId, $listener);

        return array($providerId, $listenerId, 'fos_facebook.security.authentication.entry_point');
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'fos_facebook';
    }
}
