LifterLMS Tests
===============

LifterLMS Tests is a project to help bootstrap automated testsing in LifterLMS projects.

## Installation

`composer install --dev lifterlms/lifterlms-tests`

## Predefined scripts

The following scripts can be added to your `composer.json` file for easy access to thes scripts & to ensure configurations are automatically set during package installation and updates.

```json
"scripts": {
    "tests-install": [
      "vendor/bin/llms-tests-teardown llms_tests root password localhost",
      "vendor/bin/llms-tests-install llms_tests root password localhost nightly"
    ],
    "tests-run": [
      "vendor/bin/phpunit"
    ]
}
```
