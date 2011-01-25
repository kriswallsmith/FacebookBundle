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
        
        $options = array(
            'check_path'                     => '/login_check',
            'login_path'                     => '/login',
            'use_forward'                    => false,
            'always_use_default_target_path' => false,
            'default_target_path'            => '/',
            'target_path_parameter'          => '_target_path',
            'use_referer'                    => false,
            'failure_path'                   => null,
            'failure_forward'                => false,
        );
        foreach (array_keys($options) as $key) {
            if (isset($config[$key])) {
                $options[$key] = $config[$key];
            }
        }
        $arguments[2] = $options;
        
        $container->setParameter('fos_facebook.security.authentication.options', $options);
        $container->setParameter('fos_facebook.security.authentication.check_path', $options['check_path']);
        
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
