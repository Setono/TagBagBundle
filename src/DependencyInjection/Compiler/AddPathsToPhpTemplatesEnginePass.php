<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection\Compiler;

use InvalidArgumentException;
use ReflectionClass;
use function Safe\sprintf;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class AddPathsToPhpTemplatesEnginePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('setono_php_templates.engine.default')) {
            return;
        }

        self::addGtagPaths($container);
    }

    private static function addGtagPaths(ContainerBuilder $container): void
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

        $path = dirname($filename, 2) . '/templates';

        if (!is_dir($path)) {
            throw new InvalidArgumentException(sprintf('The path "%s" is not a valid directory', $path));
        }

        $engine = $container->getDefinition('setono_php_templates.engine.default');
        $engine->addMethodCall('addPath', [$path]);
    }
}
