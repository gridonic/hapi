<?php
define('BASE_PATH', __DIR__ .'/..');

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Harvest\Tests', __DIR__);
