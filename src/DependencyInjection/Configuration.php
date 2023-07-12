<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection;

use Symfony\Bundle\TwigBundle\TwigBundle;
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
                ->arrayNode('renderer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('twig')
                            ->defaultValue(class_exists(TwigBundle::class))
                            ->info('Whether to enable the twig renderer')
        ;

        return $treeBuilder;
    }
}
