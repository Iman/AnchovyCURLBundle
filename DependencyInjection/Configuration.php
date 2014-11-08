<?php

namespace Anchovy\CURLBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('anchovy_curl');
        $rootNode
            ->children()
                ->booleanNode('return_transfer')->defaultTrue()->end()
                ->booleanNode('follow_location')->defaultTrue()->end()
                ->scalarNode('max_redirects')->defaultValue(5)->end()
                ->scalarNode('timeout')->defaultValue(25)->end()
                ->scalarNode('connect_timeout')->defaultValue(25)->end()
                ->booleanNode('crlf')->defaultTrue()->end()
                ->scalarNode('ssl_version')->defaultValue(3)->end()
                ->scalarNode('ssl_verify')->defaultValue(0)->end()
                    ->arrayNode('http_header')
                        ->beforeNormalization()
                            ->ifTrue(function ($param) { return !is_array($param); })
                            ->then(function ($param) { return array($param); })
                        ->end()
                        ->prototype('scalar')->end()
                    ->end()
            ->end();

        return $treeBuilder;
    }
}
