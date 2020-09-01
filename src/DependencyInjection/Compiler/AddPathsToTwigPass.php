<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection\Compiler;

use InvalidArgumentException;
use ReflectionClass;
use function Safe\sprintf;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class AddPathsToTwigPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('twig.loader.native_filesystem')) {
            return;
        }

        $twigLoader = $container->getDefinition('twig.loader.native_filesystem');

        self::addGtagPaths($twigLoader);
    }

    private static function addGtagPaths(Definition $twigLoader): void
    {
        $interface = 'Setono\TagBag\Tag\GtagInterface';

        if (!interface_exists($interface)) {
            return;
        }

        $filename = (new ReflectionClass($interface))->getFileName();
        if (false === $filename) {
            throw new InvalidArgumentException(sprintf(
                'The filename of interface %s could not be deduced', $interface
            ));
        }

        $path = dirname($filename, 2) . '/templates/SetonoTagBagGtag';

        if (!is_dir($path)) {
            throw new InvalidArgumentException(sprintf('The path "%s" is not a valid directory', $path));
        }

        $twigLoader->addMethodCall('addPath', [$path, 'SetonoTagBagGtag']);
    }
}
