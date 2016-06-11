# soluble-japha-pjb62-compat

[![PHP Version](http://img.shields.io/badge/php-5.4+-ff69b4.svg)](https://packagist.org/packages/soluble/japha-pjb62-compat)
[![HHVM Status](http://hhvm.h4cc.de/badge/soluble/japha-pjb62-compat.png?style=flat)](http://hhvm.h4cc.de/package/soluble/japha-pjb62-compat)
[![Build Status](https://travis-ci.org/belgattitude/soluble-japha-pjb62-compat.png?branch=master)](https://travis-ci.org/belgattitude/soluble-japha-pjb62-compat)
[![Code Coverage](https://scrutinizer-ci.com/g/belgattitude/soluble-japha-pjb62-compat/badges/coverage.png?s=aaa552f6313a3a50145f0e87b252c84677c22aa9)](https://scrutinizer-ci.com/g/belgattitude/soluble-japha-pjb62-compat/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/belgattitude/soluble-japha-pjb62-compat/badges/quality-score.png?s=6f3ab91f916bf642f248e82c29857f94cb50bb33)](https://scrutinizer-ci.com/g/belgattitude/soluble-japha-pjb62-compat/)
[![Latest Stable Version](https://poser.pugx.org/soluble/japha-pjb62-compat/v/stable.svg)](https://packagist.org/packages/soluble/japha-pjb62-compat)
[![Total Downloads](https://poser.pugx.org/soluble/japha-pjb62-compat/downloads.png)](https://packagist.org/packages/soluble/japha-pjb62-compat)
[![License](https://poser.pugx.org/soluble/japha-pjb62-compat/license.png)](https://packagist.org/packages/soluble/japha-pjb62-compat)

## Introduction

Compatibility layer for legacy use of PHPJavaBridge.

## Features

- Make soluble-japha compatible with procedural the phpjavabridge legacy api

## Requirements

- PHP 5.4+, 7.0 or HHVM >= 3.2.
- The [PHPJavaBridge server running](./doc/install_server.md)


## Installation

1. Installation in your PHP project

   Via [composer](http://getcomposer.org/).

   ```console
   $ composer require soluble/japha soluble/japha-pjb62-compat
   ```

   Most modern frameworks will include Composer out of the box, but ensure the following file is included:

   ```php
   <?php
   // include the Composer autoloader
   require 'vendor/autoload.php';
   ```

2. Installation of the phpjavabridge server

   Refer to the documentation provided in the [soluble-japha server install](https://github.com/belgattitude/soluble-japha/blob/master/doc/install_server.md) project.

## Examples

### Connection example

Once your phpjavabridge servlet is running, you first have to initiate a connection.

```php
<?php

use Soluble\Japha\Bridge\Adapter as BridgeAdapter;

$ba = new BridgeAdapter([
    'driver' => 'Pjb62',
    'servlet_address' => 'localhost:8083/servlet.phpjavabridge'
]);
```

### Basic Java usage


## Coding standards

* [PSR 4 Autoloader](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md)
* [PSR 2 Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
* [PSR 1 Coding Standards](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)
* [PSR 0 Autoloading standards](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)



