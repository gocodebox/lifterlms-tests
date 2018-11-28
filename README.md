LifterLMS Tests
===============

LifterLMS Tests is a project to help bootstrap automated testsing in LifterLMS projects.

## Installation

+ Install package: `composer install --dev lifterlms/lifterlms-tests`
+ Create a `phpunit.xml.dist` file. See [example](examples/phpunit.xml.dist).
+ Add a `tests` direcotry: `mkdir tests`
+ Create a bootstrap file in the `tests` directory. see [example](examples/bootstrap.php).
+ Add test classes in `tests/unit-tests`

## Commands

+ Install Testing Suite: `./vendor/bin/llms-tests install <db-name> <db-user> <db-pass> [db-host] [wp-version] [skip-database-creation]`
+ Teardown Testing Suite: `.vendor/bin/llms-tests teardown <db-name> <db-user> <db-pass> [db-host]`
+ Install a Plugin: `./vendor/bin/llms-tests plugin <slug_or_zip> [version]`
+ Run tests: `./vendor/bin/phpunit`

## Predefined scripts

The following scripts can be added to your `composer.json` file for easy access to thes scripts & to ensure configurations are automatically set during package installation and updates.

```json
"scripts": {
    "tests-install": [
      "vendor/bin/llms-tests teardown llms_tests root password localhost",
      "vendor/bin/llms-tests install llms_tests root password localhost",
      "vendor/bin/llms-tests plugin lifterlms"
    ],
    "tests-run": [
      "vendor/bin/phpunit"
    ]
}
```
