# HTTP library

## Description

> This library is just proof of concept. 
> We do **NOT** recommended the use of production environment.

Provide Message & Factory implementation

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

## Install

Package is available on [Packagist](link-packagist), you can install it using [Composer](http://getcomposer.org).

``` bash
composer require devop-core/http
```

## Usage

``` php
<?php
use DevOp\Core\Http\ServerRequestFactory;

require_once './vendor/autoload.php';

$reqest = (new ServerRequestFactory())->createServerRequestFromArray($_SERVER);
var_dump($reqest);
```

## Change log

Please see [CHANGELOG](.github/CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/devop-core/http.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/devop-core/http/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/devop-core/http.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/devop-core/http.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/devop-core/http.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/devop-core/http
[link-travis]: https://travis-ci.org/devop-core/http
[link-scrutinizer]: https://scrutinizer-ci.com/g/devop-core/http/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/devop-core/http
[link-downloads]: https://packagist.org/packages/devop-core/http
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
