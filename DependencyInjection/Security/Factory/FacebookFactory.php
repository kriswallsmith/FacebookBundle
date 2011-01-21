<?php

namespace FOS\FacebookBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class FacebookFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProviderId, $defaultEntryPoint)
    {
        if ($userProviderId != 'fos_facebook.auth') {
            $providerId = 'fos_facebook.auth.'.$id;
            $provider = clone $container->getDefinition('fos_facebook.auth');

            $arguments = $provider->getArguments();
            $arguments[] = new Reference($userProviderId);
            $arguments[] = new Reference('security.account_checker');

            $provider->setArguments($arguments);

            $container->setDefinition($providerId, $provider);
        }

        // listener
        $listenerId = 'fos_facebook.security.authentication.listener.'.$id;
        $listener = $container->setDefinition($listenerId, clone $container->getDefinition('fos_facebook.security.authentication.listener'));
        $arguments = $listener->getArguments();
        $arguments[1] = new Reference($providerId);

        if (is_array($config)) {
            $options = $container->getParameter('fos_facebook.security.authentication.options');
            $options = array_merge($options, $config);
            $arguments[2] = $options;
        }

        $listener->setArguments($arguments);

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
