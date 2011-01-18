<?php

namespace Bundle\FOS\FacebookBundle\DependencyInjection;

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
        if (!$container->hasDefinition('fos_facebook.api')) {
            $this->loadDefaults($container);
        }

        if (isset($config['alias'])) {
            $container->setAlias($config['alias'], 'fos_facebook.api');
        }

        foreach (array('class', 'file', 'app_id', 'secret', 'cookie', 'domain', 'logging', 'culture', 'permissions') as $attribute) {
            if (isset($config[$attribute])) {
                $container->setParameter('fos_facebook.'.$attribute, $config[$attribute]);
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
        return 'http://www.symfony-project.org/schema/dic/fos_facebook';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAlias()
    {
        return 'fos_facebook';
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
