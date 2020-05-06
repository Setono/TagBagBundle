<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\Twig;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\TagBagInterface;
use Setono\TagBagBundle\Twig\TagBagExtension;
use Twig\TwigFunction;

/**
 * @covers \Setono\TagBagBundle\Twig\TagBagExtension
 */
final class TagBagExtensionTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_head_tags(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->getSection(TagInterface::SECTION_HEAD)->willReturn(null);

        $extension = new TagBagExtension($tagBag->reveal());

        $this->assertSame('', $extension->headTags());
    }

    /**
     * @test
     */
    public function it_returns_body_begin_tags(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->getSection(TagInterface::SECTION_BODY_BEGIN)->willReturn(null);

        $extension = new TagBagExtension($tagBag->reveal());

        $this->assertSame('', $extension->bodyBeginTags());
    }

    /**
     * @test
     */
    public function it_returns_body_end_tags(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->getSection(TagInterface::SECTION_BODY_END)->willReturn(null);

        $extension = new TagBagExtension($tagBag->reveal());

        $this->assertSame('', $extension->bodyEndTags());
    }

    /**
     * @test
     */
    public function it_returns_multiple_sections(): void
    {
        $tagBag = $this->createMock(TagBagInterface::class);
        $tagBag
            ->method('getSection')
            ->withConsecutive(['section1'], ['section2'])
            ->willReturnOnConsecutiveCalls(null, null)
        ;

        $extension = new TagBagExtension($tagBag);

        $this->assertSame('', $extension->tags(['section1', 'section2']));
    }

    /**
     * @test
     */
    public function it_returns_all_tags(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->getAll()->willReturn([]);

        $extension = new TagBagExtension($tagBag->reveal());

        $this->assertSame('', $extension->tags());
    }

    /**
     * @test
     */
    public function it_registers_functions(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->getAll()->willReturn([]);

        $extension = new TagBagExtension($tagBag->reveal());
        $functions = $extension->getFunctions();

        $this->assertCount(4, $functions);
        $this->assertContainsOnlyInstancesOf(TwigFunction::class, $functions);
    }
}
