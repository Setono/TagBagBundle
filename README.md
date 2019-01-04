# Symfony Tag Bag Bundle
This bundle creates a session bag named `TagBag` which intended use is to inject tags into your pages.

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

You can get the `TagBag` from the session like so:

```php
<?php

/** @var Symfony\Component\HttpFoundation\Session\SessionInterface $session */
$session;

/** @var Setono\TagBagBundle\HttpFoundation\Session\Tag\TagBagInterface $tagBag */
$tagBag = $session->getBag('tags');

$tagBag->add('<script>console.log</script>', 'body_end');
```

then in your template:

```html
        <!-- ... -->
        {% for tag in tag_bag.tags('body_end') %}
            {{ tag|raw }}
        {% endfor %}
    </body>
</html>
```

If you need the `TagBag` injected you can use the service `session.tag_bag`, i.e.:

```php
<?php

class YourService
{
    private $tagBag;
    
    public function __construct(Setono\TagBagBundle\HttpFoundation\Session\Tag\TagBagInterface $tagBag) 
    {
        $this->tagBag = $tagBag;
    }
    
    public function method(): void 
    {
        $this->tagBag->add('<script>console.log</script>', 'body_end');
    }
}
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

[ico-version]: https://img.shields.io/packagist/v/setono/tag-bag-bundle.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://travis-ci.com/Setono/TagBagBundle.svg?branch=master
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/TagBagBundle.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/tag-bag-bundle
[link-travis]: https://travis-ci.com/Setono/TagBagBundle
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/TagBagBundle
