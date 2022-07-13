<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\Twig;

use Setono\TagBag\Renderer\CompositeRenderer;
use Setono\TagBag\Renderer\ContentAwareRenderer;
use Setono\TagBag\Renderer\ElementRenderer;
use Setono\TagBag\Tag\ContentAwareTag;
use Setono\TagBag\Tag\InlineScriptTag;
use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\TagBag;
use Setono\TagBagBundle\Twig\Extension;
use Setono\TagBagBundle\Twig\Runtime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\Test\IntegrationTestCase;

final class ExtensionTest extends IntegrationTestCase
{
    public function getRuntimeLoaders(): array
    {
        $runtimeLoader = new class() implements RuntimeLoaderInterface {
            /**
             * @param string $class
             */
            public function load($class): Runtime
            {
                $renderer = new CompositeRenderer();
                $renderer->add(new ElementRenderer());
                $renderer->add(new ContentAwareRenderer());
                $tagBag = new TagBag($renderer);

                $tagBag->add(InlineScriptTag::create('alert("header")')->withSection(TagInterface::SECTION_HEAD));
                $tagBag->add(InlineScriptTag::create('alert("body begin")')->withSection(TagInterface::SECTION_BODY_BEGIN));
                $tagBag->add(InlineScriptTag::create('alert("body end")')->withSection(TagInterface::SECTION_BODY_END));
                $tagBag->add(ContentAwareTag::create('<div class="tag-1">content 1</div>')->withSection('section1'));
                $tagBag->add(ContentAwareTag::create('<div class="tag-2">content 2</div>')->withSection('section2'));

                return new Runtime($tagBag);
            }
        };

        return [$runtimeLoader];
    }

    public function getExtensions(): array
    {
        return [
            new Extension(),
        ];
    }

    public function getFixturesDir(): string
    {
        return __DIR__ . '/Fixtures/';
    }
}
