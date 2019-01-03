<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection;

use Setono\TagBagBundle\Twig\GlobalVariable;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoTagBagExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        if(!$container->has('twig')) {
            return;
        }

        $container->prependExtensionConfig('twig', [
            'globals' => [
                'tag_bag' => '@'.GlobalVariable::class
            ]
        ]);
    }
}
