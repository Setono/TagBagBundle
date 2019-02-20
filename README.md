# Symfony Tag Bag Bundle
This bundle creates a session bag named `tags` which intended use is to inject tags into your pages.

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

## Installation

### Step 1: Download

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```bash
$ composer require setono/tag-bag-bundle
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

### Step 2: Enable the bundle

If you use Symfony Flex it will be enabled automatically. Else you need to add it to the `bundles.php`.

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
use Setono\TagBagBundle\Tag\ScriptTag;
use Setono\TagBagBundle\TagBag\TagBagInterface;

class YourService
{
    private $tagBag;
    
    public function __construct(TagBagInterface $tagBag) 
    {
        $this->tagBag = $tagBag;
    }
    
    public function method(): void 
    {
        $this->tagBag->add(
            // the script tag will be wrapped in <script> tags when outputted
            new ScriptTag('console.log("This will be output in the console");'),
            // This is one of three predefined sections. You can use your own custom section if you need to
            TagBagInterface::SECTION_BODY_END
        );
    }
}
```

To output all the tags you've defined, including tags in custom sections, you can use a template like this:

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{% block title %}Welcome!{% endblock %}</title>
        {% block stylesheets %}{% endblock %}
        {{ setono_tag_bag_head_tags() }}
    </head>
    <body>
        {{ setono_tag_bag_body_begin_tags() }}
        
        <h1>This is your page content</h1>
        <p>Lorem ipsum</p>
        
        {{ setono_tag_bag_body_end_tags() }}
        {{ setono_tag_bag_tags() }}
    </body>
</html>
```

then in your service definition:

```xml
<?xml version="1.0" encoding="UTF-8" ?>

<container xmlns="http://symfony.com/schema/dic/services" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">
    <services>
        <service id="YourService">
            <argument type="service" id="session.tag_bag"/>
        </service>
    </services>
</container>
```

### Twig functions

In the `TagBagInterface` there are three constants you can use for common sections on a web page, i.e. `head`, `body_begin`, `body_end`.

Also there are three associated twig functions for those sections: `setono_tag_bag_head_tags()`, `setono_tag_bag_body_begin_tags()`, `setono_tag_bag_body_end_tags()`

[ico-version]: https://img.shields.io/packagist/v/setono/tag-bag-bundle.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://travis-ci.com/Setono/TagBagBundle.svg?branch=master
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/TagBagBundle.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/tag-bag-bundle
[link-travis]: https://travis-ci.com/Setono/TagBagBundle
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/TagBagBundle
