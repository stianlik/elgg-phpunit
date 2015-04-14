# Elgg PHPUnit

Simple test configuration to support integration testing in Elgg using
PHPUnit. Assumes the default directory structure for Elgg 1.9.

## Installation

Install test configuration into your plugin using composer:

```Shell
composer require foogile/elgg-phpunit
```

## Usage

There are three default PHPUnit configurations that can be used to run all unit tests, all
integration tests, or all tests. Unit tests are placed in `PLUGIN/tests/unit` adn  integration tests
are placed in `PLUGIN/tests/integration`.  You can modify the Elgg configuration for the test
environment by creating a file named `PLUGIN/tests/integration/settings.phpunit.php`.

### Bootstrap

You can run custom init code by creating `PLUGIN/tests/integration/bootstrap.php` and
`PLUGIN/tests/unit/bootstrap.php` for integration and unit tests, respectively.

### Run unit tests

```Shell
phpunit -c vendor/foogile/elgg-phpunit/phpunit.unit.xml
```

### Run integration tests

```Shell
phpunit -c vendor/foogile/elgg-phpunit/phpunit.integration.unit.xml
```

### Run all tests

```Shell
phpunit -c vendor/foogile/elgg-phpunit/phpunit.xml
```

### Elgg installation helper

It is included a utility script to install an Elgg test environment. To
initialize the database, specify your database setup in 
`PLUGIN/tests/integration/settings.phpunit.php` and execute the following
from the root folder of your plugin:

```Shell
php vendor/foogile/elgg-phpunit/install.php
```
