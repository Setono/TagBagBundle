<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection\Compiler;

use Setono\TagBagBundle\Session\SessionConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SessionConfiguratorPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('session')) {
            return;
        }

        $session = $container->getDefinition('session');

        // just to make sure nobody else (symfony core, other bundle) sets a configurator and we overwrite it here
        if (null !== $session->getConfigurator()) {
            throw new InvalidConfigurationException('The session service already defines a configurator.');
        }

        $session->setConfigurator([new Reference(SessionConfigurator::class), 'configure']);
    }
}
