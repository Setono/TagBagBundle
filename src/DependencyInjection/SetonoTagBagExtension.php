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
    public function load(array $config, ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(RendererInterface::class)
            ->addTag('setono_tag_bag.renderer', [
                'priority' => 256,
            ])
        ;

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if (class_exists('Setono\TagBag\Tag\TwigTagInterface')) {
            $loader->load('services/integrations/tag_bag_twig.xml');
        }

        if (class_exists('Setono\TagBag\Tag\PhpTemplatesTagInterface')) {
            $loader->load('services/integrations/tag_bag_php_templates.xml');
        }
    }
}
