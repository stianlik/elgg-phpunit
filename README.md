# Elgg PHPUnit

Simple test configuration to support integration testing for Elgg using
PHPUnit. Assumes the default directory structure for Elgg 1.9 is in use.

## Installation

Install test configuration into your plugin using composer:

```PHP
composer install foogile/elgg-phpunit
```

## Usage

There are three default PHPUnit configurations that can be used to run all unit tests, all
integration tests, or all tests. Unit tests are placed in `PLUGIN/tests/unit` adn  integration tests
are placed in `PLUGIN/tests/integration`.  You can modify the Elgg configuration for the test
environment by creating a file named `PLUGIN/tests/integration/settings.phpunit.php`.

Tests are executed as follows:

```Shell
# Run unit tests
phpunit -c vendor/foogile/elgg-phpunit/phpunit.unit.xml

# Run integration tests
phpunit -c vendor/foogile/elgg-phpunit/phpunit.integration.unit.xml

# Run all tests
phpunit -c vendor/foogile/elgg-phpunit/phpunit.xml
```
