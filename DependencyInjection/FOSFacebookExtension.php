<?php

namespace FOS\FacebookBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Configuration\Processor;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class FOSFacebookExtension extends Extension
{
    protected $resources = array(
        'facebook' => 'facebook.xml',
        'security' => 'security.xml',
    );

    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->process($configuration->getConfigTree(), $configs);

        $this->loadDefaults($container);

        if (isset($config['alias'])) {
            $container->setAlias($config['alias'], 'fos_facebook.api');
        }

        foreach (array('api', 'helper', 'twig') as $attribute) {
            $container->setParameter('fos_facebook.' . $attribute . '.class', $config['class'][$attribute]);
        }

        foreach (array('file', 'app_id', 'secret', 'cookie', 'domain', 'logging', 'culture', 'permissions') as $attribute) {
            $container->setParameter('fos_facebook.' . $attribute, $config[$attribute]);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__ . '/../Resources/config/schema';
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
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach ($this->resources as $resource) {
            $loader->load($resource);
        }
    }
}
