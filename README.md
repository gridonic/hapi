HaPi – Harvest API
==================

PHP Wrapper Library for the Harvest API.

[![Build Status](https://travis-ci.org/gridonic/hapi.svg?branch=master)](https://travis-ci.org/gridonic/hapi)
[![Code Climate](https://codeclimate.com/github/gridonic/hapi/badges/gpa.svg)](https://codeclimate.com/github/gridonic/hapi)

Usage
-----

```php
<?php
require __DIR__ . '/vendor/autoload.php';

$api = new Harvest\HarvestApi();
$api->setUser('your@email.com');
$api->setPassword('password');
$api->setAccount('account');

$result = $api->getClient(12345);
```

Run tests
---------

Tests include some live API calls by default. For this to work, you will have to create a local copy of
```harvest_api_config.json``` by copying the provided ```harvest_api_config.json.dist``` and providing your own
Harvest account credentials.

In order to exclude the tests that require a valid Harvest account and internet connection, invoke the test runner
as follows:

    phpunit --exclude-group=internet

License
-------

Hapi is licensed under the GPL-3 License - see the `LICENSE` file for details

Acknowledgements
----------------

This version of the library is a rewrite that uses composer and proper PSR-0 standard
for autoloading. The original version of the library was written by Matthew John Denton
and can be downloaded from http://labs.mdbitz.com/harvest-api

Submitting bugs and feature requests
------------------------------------

Since this is a rewrite, it is very well possible that some parts of the library
do not work yet or anymore. Bugs and feature request are tracked on [GitHub](https://github.com/gridonic/hapi/issues)
