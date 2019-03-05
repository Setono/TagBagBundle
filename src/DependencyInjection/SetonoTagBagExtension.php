<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoTagBagExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $container->setParameter('setono_tag_bag.session_key', $config['session_key']);
        $loader->load('services.xml');
    }
}
