<?php


namespace QiniuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package QiniuBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $root = $treeBuilder->root('qiniu');

        $root
            ->children()
            ->scalarNode('access_key')
            ->defaultNull()
            ->end()
            ->scalarNode('secret_key')
            ->defaultNull()
            ->end()
            ->scalarNode('domain')
            ->defaultNull()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
