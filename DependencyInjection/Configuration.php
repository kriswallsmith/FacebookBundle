<?php

namespace FOS\FacebookBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Configuration\Builder\NodeBuilder;
use Symfony\Component\DependencyInjection\Configuration\Builder\TreeBuilder;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * @author Lukas Kahwe Smith <smith@pooteeweet.org>
 */
class Configuration
{
    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\DependencyInjection\Configuration\NodeInterface
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fos_facebook', 'array');

        $rootNode
            ->scalarNode('app_id')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('secret')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('file')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('cookie')->defaultFalse()->end()
            ->scalarNode('domain')->defaultNull()->end()
            ->scalarNode('alias')->defaultNull()->end()
            ->scalarNode('logging')->defaultValue('%kernel.debug%')->end()
            ->scalarNode('culture')->defaultValue('en_US')->end()
            ->arrayNode('class')
                ->addDefaultsIfNotSet()
                    ->scalarNode('api')->defaultValue('Facebook')->end()
                    ->scalarNode('helper')->defaultValue('FOS\FacebookBundle\Templating\Helper\FacebookHelper')->end()
                    ->scalarNode('twig')->defaultValue('FOS\FacebookBundle\Twig\Extension\FacebookExtension')->end()
                ->end()
            ->arrayNode('permissions')->prototype('scalar')->end();

        return $treeBuilder->buildTree();
    }

}
