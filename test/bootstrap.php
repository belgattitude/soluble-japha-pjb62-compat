<?php

if (!$loader = @include __DIR__ . '/../vendor/autoload.php') {
    die('You must set up the project dependencies, run the following commands:' . PHP_EOL .
            'curl -s http://getcomposer.org/installer | php' . PHP_EOL .
            'php composer.phar install' . PHP_EOL);
}

ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('memory_limit', '256M');

$baseDir = dirname(__DIR__);
require_once dirname(__FILE__) . '/SolubleTestFactories.php';

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('SolubleTest', [$baseDir . '/test/']);
$loader->register();
