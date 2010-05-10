<?php

namespace Bundle\FacebookBundle\DependencyInjection;

use Symfony\Components\DependencyInjection\Loader\LoaderExtension;
use Symfony\Components\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Components\DependencyInjection\BuilderConfiguration;
use Symfony\Components\DependencyInjection\ContainerInterface;

class FacebookExtension extends LoaderExtension
{
    protected $resources = array(
        'facebook' => 'facebook.xml',
    );

    public function apiLoadDefaults()
    {
        $configuration = new BuilderConfiguration();

        $loader = new XmlFileLoader(__DIR__.'/../Resources/config');
        $configuration->merge($loader->load($this->resources['facebook']));

        return $configuration;
    }

    public function apiLoad($config)
    {
        $configuration = new BuilderConfiguration();

        foreach ($config as $key => $value) {
            $configuration->setParameter('facebook.' . $key, $value);
        }

        return $configuration;
    }

    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/';
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
