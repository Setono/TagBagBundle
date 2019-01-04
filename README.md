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

[ico-version]: https://img.shields.io/packagist/v/setono/tag-bag-bundle.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Setono/TagBagBundle/master.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/TagBagBundle.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/tag-bag-bundle
[link-travis]: https://travis-ci.com/Setono/TagBagBundle
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/TagBagBundle
