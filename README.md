# soluble-japha-pjb62-compat

[![PHP Version](http://img.shields.io/badge/php-5.4+-ff69b4.svg)](https://packagist.org/packages/soluble/japha-pjb62-compat)
[![HHVM Status](http://hhvm.h4cc.de/badge/soluble/japha-pjb62-compat.png?style=flat)](http://hhvm.h4cc.de/package/soluble/japha-pjb62-compat)
[![Build Status](https://travis-ci.org/belgattitude/soluble-japha-pjb62-compat.png?branch=master)](https://travis-ci.org/belgattitude/soluble-japha-pjb62-compat)
[![Code Coverage](https://scrutinizer-ci.com/g/belgattitude/soluble-japha-pjb62-compat/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/belgattitude/soluble-japha-pjb62-compat/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/belgattitude/soluble-japha-pjb62-compat/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/belgattitude/soluble-japha-pjb62-compat/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/soluble/japha-pjb62-compat/v/stable.svg)](https://packagist.org/packages/soluble/japha-pjb62-compat)
[![Total Downloads](https://poser.pugx.org/soluble/japha-pjb62-compat/downloads.png)](https://packagist.org/packages/soluble/japha-pjb62-compat)
[![License](https://poser.pugx.org/soluble/japha-pjb62-compat/license.png)](https://packagist.org/packages/soluble/japha-pjb62-compat)

## Introduction

*** Work in progress ***

*Historically the [PHP/Java bridge](http://php-java-bridge.sourceforge.net/pjb/) client didn't
support namespaces.* 

*Install this package if you have existing code relying on legacy php-java-bridge and 
don't want to refactor to the newer implementation provided by [soluble/japha](https://github.com/belgattitude/soluble-japha).*  


## Features

- Make [soluble-japha](https://github.com/belgattitude/soluble-japha) compatible with the procedural phpjavabridge legacy api

## Requirements

- PHP 5.4+, 7.0 or HHVM >= 3.2.
- The [PHPJavaBridge server running](./doc/install_server.md)

## Installation

1. PHP installation *(client)*

   Through [composer](http://getcomposer.org/).

   ```console
   $ composer require "soluble/japha-pjb62-compat"
   ```

   Most modern frameworks will include Composer out of the box, but ensure the following file is included:

   ```php
   <?php
   // include the Composer autoloader
   require 'vendor/autoload.php';
   ```

2. PHP-Java-bridge server

   Refer to the latest documentation provided in the [soluble-japha](https://github.com/belgattitude/soluble-japha/blob/master/README.md) project.

   Or as quick install guide use the standalone server :
      
   ```console
   $ mkdir -p /my/path/pjbserver-tools
   $ cd /my/path/pjbserver-tools
   $ composer create-project --no-dev --prefer-dist "belgattitude/pjbserver-tools"
   $ ./bin/pjbserver-tools pjbserver:start -vvv ./config/pjbserver.config.php.dist
   ```
   The server will start on default port ***8089***. If you like to change it, create a local copy of `./config/pjbserver.config.php.dist`
   and refer it in the above command.
   
   Use the commands `pjbserver:stop`, `pjbserver:restart`, `pjbserver:status` to control or query the server status.
       
   *For production the recommended way is to deploy the JavaBridge servlet into a J2EE compatible server (Tomcat,...).
   Have a look to the complete [java server installation documentation](./doc/install_server.md).*
   
## Examples

### Connection example

Configure your bridge adapter with the correct driver (currently only Pjb62 is supported) and the PHP-Java-bridge server address.

```php
<?php

use Soluble\Japha\Bridge\Adapter as BridgeAdapter;

$ba = new BridgeAdapter([
    'driver' => 'Pjb62',
    'servlet_address' => 'localhost:8089/servlet.phpjavabridge'
]);
```

This replace the `include('xxx/Java.inc)` used in previous versions. 

### Basic Java usage

With legacy mode enabled you can use the java* function directly
 
```php
<?php

use Soluble\Japha\Bridge\Adapter as BridgeAdapter;

$ba = new BridgeAdapter([
    'driver' => 'Pjb62',
    'servlet_address' => 'localhost:8083/servlet.phpjavabridge'
]);

$bigint = new Java("java.math.BigInteger", 1);
$system = java_class('java.lang.System);

java_instanceof($bigint, 'java.math.BigInteger'); // -> true
java_inspect($bigint); 
java_values($bigint);
//java_invoke();

``` 

### API

### Refactor constants

|Constant                    | Example                                   |
|----------------------------|-------------------------------------------|
| `JAVA_HOSTS`               | `define("JAVA_HOSTS", "127.0.0.1:8787")` |
| `JAVA_SERVLET`             | `define("JAVA_SERVLET", "/MyWebApp/servlet.phpjavabridge")` |
| `JAVA_PREFER_VALUES`       | `define("JAVA_PREFER_VALUES", 1)` |
| `JAVA_LOG_LEVEL`           | `define("JAVA_LOG_LEVEL", null)` |
| `JAVA_SEND_SIZE`           | `define("JAVA_SEND_SIZE", 8192)` |
| `JAVA_RECV_SIZE`           | `define("JAVA_RECV_SIZE", 8192)` |
| `JAVA_DISABLE_AUTOLOAD`    | Not applicable anymore - PSR4 ;) |

### Initialization

| Old way                    | New way                     |
|----------------------------|-------------------------------------------|
|`include(... /Java.inc)`    | `$ba = new Bridge\Adapter($option);` |


### API

The following table maps old and new recommended API.

|Legacy                                           | `Bridge\Adapter` ($ba)                      |
|-------------------------------------------------|-------------------------------------------|
|`new Java($class, $args=null)` : `Java`          | `$ba->java($class, $args=null)` : `Interfaces\JavaObject`          |
|`java_class($class)` : `JavaClass`               | `$ba->javaClass($class)` `Interfaces\JavaClass`                |
|`java_instanceof($object, $class)` : `boolean`   | `$ba->isInstanceOf($object, $class)` : `boolean`    |





(under review, soon to be implemented)

|Legacy                                      | `Bridge\Adapter` ($ba)                      |
|--------------------------------------------|------------------------------------------|
|`java_values($object)` : `mixed`            | `$ba->getValues($object)` : `mixed`               |
|`java_invoke($object, $method, $args=null)` : `mixed|null` | `$ba->invokeMethod($object, $method, $args=null) : `string\null`  |
|`java_inspect($object)` : `string`          | `$ba->debug()->inspect($object)` : `string`               |
|`getLastException` : `Exception`            | `$ba->debug()->getLastException()` : `Exception`  |
|`clearLastException`                        | `$ba->debug()->clearLastException()`  |


function java_is_null($value)
function java_is_true($value)
function java_is_false($value)



## Refactoring guidelines

Keep a step by step approach... you can use both API at the same time.

1. Try to change intialization sequence 


## Coding standards

* [PSR 4 Autoloader](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md)
* [PSR 2 Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
* [PSR 1 Coding Standards](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)
* [PSR 0 Autoloading standards](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)



