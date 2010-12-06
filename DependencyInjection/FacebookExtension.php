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
            $this->loadDefaults($container);
        }

        if (isset($config['alias'])) {
            $container->setAlias($config['alias'], 'kris.facebook');
        }

        foreach (array('class', 'file', 'app_id', 'secret', 'cookie', 'domain', 'logging', 'culture', 'permissions') as $attribute) {
            if (isset($config[$attribute])) {
                $container->setParameter('kris.facebook.'.$attribute, $config[$attribute]);
            }
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getNamespace()
    {
        return 'http://kriswallsmith.net/schema/dic/facebook';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAlias()
    {
        return 'facebook';
    }

    /**
     * @codeCoverageIgnore
     */
    protected function loadDefaults($container)
    {
        $loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');
        $loader->load($this->resources['facebook']);
    }
}
