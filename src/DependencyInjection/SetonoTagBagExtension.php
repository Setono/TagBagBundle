<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection;

use Setono\TagBag\Renderer\RendererInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoTagBagExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        /**
         * @psalm-suppress PossiblyNullArgument
         *
         * @var array{renderer: array{twig: bool}} $config
         */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        $container->registerForAutoconfiguration(RendererInterface::class)
            ->addTag('setono_tag_bag.renderer', [
                'priority' => 128,
            ])
        ;

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if (true === $config['renderer']['twig']) {
            $loader->load('services/integrations/renderer.xml');
        }
    }
}
