<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('setono_tag_bag');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('session_key')
                    ->defaultValue('setono_tag_bag_tags')
                    ->info('The key to be used when saving the tag bag in the session, i.e. when calling $session->set(\'key\')')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
