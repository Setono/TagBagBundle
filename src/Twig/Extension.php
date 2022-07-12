<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class Extension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('setono_tag_bag_render_all', [Runtime::class, 'renderAll'], ['is_safe' => ['html']]),
            new TwigFunction('setono_tag_bag_render_section', [Runtime::class, 'renderSection'], ['is_safe' => ['html']]),
            new TwigFunction('setono_tag_bag_render_head', [Runtime::class, 'renderHead'], ['is_safe' => ['html']]),
            new TwigFunction('setono_tag_bag_render_body_begin', [Runtime::class, 'renderBodyBegin'], ['is_safe' => ['html']]),
            new TwigFunction('setono_tag_bag_render_body_end', [Runtime::class, 'renderBodyEnd'], ['is_safe' => ['html']]),
        ];
    }
}
