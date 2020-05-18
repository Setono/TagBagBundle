# Symfony Tag Bag Bundle

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Coverage Status][ico-code-coverage]][link-code-coverage]
[![Quality Score][ico-code-quality]][link-code-quality]

This bundle integrates the [tag bag library](https://github.com/Setono/tag-bag) and creates a service named
`setono_tag_bag.tag_bag` which you can use to inject tags onto pages.

It is especially useful when you want to inject tags that are dynamic by nature. This could be ecommerce tracking,
affiliate tracking etc.

It works by adding tags to the tag bag within the request cycle. When the request cycle is done, the remaining tags will
be saved to the session. On a new page load, the tag bag will be restored. This is what makes it extremely versatile when
you want to track events in your HTML, but the event is happening in a service/controller somewhere.

## Installation

### Step 1: Download

```bash
$ composer require setono/tag-bag-bundle
```

### Step 2: Enable the bundle

If you use [Symfony Flex](https://flex.symfony.com/) it will be enabled automatically. Else you need to add it to the `config/bundles.php`:

```php
<?php
// config/bundles.php

return [
    // ...

    Setono\TagBagBundle\SetonoTagBagBundle::class => ['all' => true],

    // ...
];
```

## Usage
You can autowire the `TagBag` like this:

```php
<?php
use Setono\TagBag\Tag\ScriptTag;
use Setono\TagBag\TagBagInterface;

class YourService
{
    private $tagBag;
    
    public function __construct(TagBagInterface $tagBag) 
    {
        $this->tagBag = $tagBag;
    }
    
    public function method(): void 
    {
        $this->tagBag->addTag(
            new ScriptTag('console.log("This will be output in the console");')
        );
    }
}
```

To output all the tags you've defined, including tags in custom sections, you can use a template like this:

```twig
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{% block title %}Welcome!{% endblock %}</title>
        {% block stylesheets %}{% endblock %}
        {{ setono_tag_bag_render_head() }}
    </head>
    <body>
        {{ setono_tag_bag_render_body_begin() }}
        
        <h1>This is your page content</h1>
        <p>Lorem ipsum</p>
        
        {{ setono_tag_bag_render_section('custom_section') }}        

        <h2>More page content</h2>
        <p>Lorem ipsum</p>

        
        {{ setono_tag_bag_render_body_end() }}
        {{ setono_tag_bag_render_all() }} {# This is a catch all that will output the tags that wasn't output before #}
    </body>
</html>
```

## Projects using Tag Bag Bundle
- [Sylius Addwish plugin](https://github.com/Setono/SyliusAddwishPlugin)
- [Sylius Strands plugin](https://github.com/Setono/SyliusStrandsPlugin)
- [Sylius Analytics plugin](https://github.com/Setono/SyliusAnalyticsPlugin)

[ico-version]: https://poser.pugx.org/setono/tag-bag-bundle/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/tag-bag-bundle/v/unstable
[ico-license]: https://poser.pugx.org/setono/tag-bag-bundle/license
[ico-github-actions]: https://github.com/Setono/TagBagBundle/workflows/build/badge.svg
[ico-code-coverage]: https://img.shields.io/scrutinizer/coverage/g/Setono/TagBagBundle.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/TagBagBundle.svg

[link-packagist]: https://packagist.org/packages/setono/tag-bag-bundle
[link-github-actions]: https://github.com/Setono/TagBagBundle/actions
[link-code-coverage]: https://scrutinizer-ci.com/g/Setono/TagBagBundle/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/TagBagBundle
