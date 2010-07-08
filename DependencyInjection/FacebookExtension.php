<?php

namespace Bundle\Kris\FacebookBundle\DependencyInjection;

use Symfony\Components\DependencyInjection\Loader\LoaderExtension;
use Symfony\Components\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Components\DependencyInjection\BuilderConfiguration;
use Symfony\Components\DependencyInjection\ContainerInterface;

class FacebookExtension extends LoaderExtension
{
    protected $resources = array(
        'facebook' => 'facebook.xml',
    );

    public function apiLoad($config, BuilderConfiguration $configuration)
    {
        if (!$configuration->hasDefinition('facebook')) {
            $loader = new XmlFileLoader(__DIR__.'/../Resources/config');
            $configuration->merge($loader->load($this->resources['facebook']));
        }

        foreach (array('class', 'app_id', 'secret', 'cookie', 'domain', 'logging', 'culture', 'xfbml') as $attribute) {
            if (isset($config[$attribute])) {
                $configuration->setParameter('facebook.'.$attribute, $config[$attribute]);
            }
        }

        return $configuration;
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
