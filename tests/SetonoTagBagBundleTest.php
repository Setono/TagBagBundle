<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests;

use Nyholm\BundleTest\BaseBundleTestCase;
use Nyholm\BundleTest\CompilerPass\PublicServicePass;
use Setono\TagBag\Renderer\CompositeRenderer;
use Setono\TagBag\Renderer\ContentRenderer;
use Setono\TagBag\Renderer\ScriptRenderer;
use Setono\TagBag\Renderer\StyleRenderer;
use Setono\TagBag\Renderer\TwigRenderer;
use Setono\TagBag\TagBag;
use Setono\TagBag\TagBagInterface;
use Setono\TagBagBundle\EventListener\RestoreTagBagSubscriber;
use Setono\TagBagBundle\EventListener\StoreTagBagSubscriber;
use Setono\TagBagBundle\SetonoTagBagBundle;
use Setono\TagBagBundle\Storage\SessionStorage;
use Setono\TagBagBundle\Twig\TagBagExtension;
use Symfony\Bundle\TwigBundle\TwigBundle;

final class SetonoTagBagBundleTest extends BaseBundleTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->addCompilerPass(new PublicServicePass('|^setono_tag_bag.*|'));
    }

    protected function getBundleClass(): string
    {
        return SetonoTagBagBundle::class;
    }

    /**
     * @test
     */
    public function it_inits(): void
    {
        $kernel = $this->createKernel();
        $kernel->addBundle(TwigBundle::class);
        $this->bootKernel();

        $container = $this->getContainer();

        // test that all services exist and is the right class
        $services = [
            // event listeners
            ['id' => 'setono_tag_bag.event_listener.restore_tag_bag_subscriber', 'class' => RestoreTagBagSubscriber::class],
            ['id' => 'setono_tag_bag.event_listener.store_tag_bag_subscriber', 'class' => StoreTagBagSubscriber::class],

            // renderers
            //['id' => RendererInterface::class, 'class' => CompositeRenderer::class], // todo why doesn't this work?
            ['id' => 'setono_tag_bag.renderer.default', 'class' => CompositeRenderer::class],
            ['id' => 'setono_tag_bag.renderer.composite', 'class' => CompositeRenderer::class],
            ['id' => 'setono_tag_bag.renderer.content', 'class' => ContentRenderer::class],
            ['id' => 'setono_tag_bag.renderer.script', 'class' => ScriptRenderer::class],
            ['id' => 'setono_tag_bag.renderer.style', 'class' => StyleRenderer::class],
            ['id' => 'setono_tag_bag.renderer.twig', 'class' => TwigRenderer::class],

            // storage
            //['id' => StorageInterface::class, 'class' => SessionStorage::class], // todo why doesn't this work?
            ['id' => 'setono_tag_bag.storage.default', 'class' => SessionStorage::class],
            ['id' => 'setono_tag_bag.storage.session', 'class' => SessionStorage::class],

            // tag bag
            //['id' => TagBagInterface::class, 'class' => TagBag::class], // todo why doesn't this work?
            ['id' => 'setono_tag_bag.tag_bag', 'class' => TagBag::class],

            // twig
            ['id' => 'setono_tag_bag.twig.tag_bag', 'class' => TagBagExtension::class],
        ];

        foreach ($services as $service) {
            $this->assertTrue($container->has($service['id']), sprintf('The container does not have a service with id: "%s"', $service['id']));
            $instance = $container->get($service['id']);
            $this->assertInstanceOf($service['class'], $instance);
        }
    }
}
