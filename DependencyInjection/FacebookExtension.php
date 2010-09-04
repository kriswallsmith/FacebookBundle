<?php

namespace Bundle\Kris\FacebookBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FacebookExtension extends Extension
{
    protected $resources = array(
        'facebook' => 'facebook.xml',
    );

    public function apiLoad($config, ContainerBuilder $container)
    {
        if (!$container->hasDefinition('kris.facebook')) {
            $loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');
            $loader->load($this->resources['facebook']);
        }

        if (isset($config['alias'])) {
            $container->setAlias($config['alias'], 'kris.facebook');
        }

        foreach (array('class', 'app_id', 'secret', 'cookie', 'domain', 'logging', 'culture') as $attribute) {
            if (isset($config[$attribute])) {
                $container->setParameter('kris.facebook.'.$attribute, $config[$attribute]);
            }
        }
    }

    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    public function getNamespace()
    {
        return 'http://kriswallsmith.net/schema/dic/facebook';
    }

    public function getAlias()
    {
        return 'facebook';
    }
}
