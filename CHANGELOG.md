LifterLMS Tests Changelog
=========================

v2.1.0 - 2021-08-26
-------------------

+ Introduced pluggable version of `llms_exit()` which throws the `LLMS_Unit_Test_Exception_Exit` exception in favor of exiting.


v2.0.2 - 2021-08-23
-------------------

+ Bugfix: Fixed static property retrieval via `LLMS_Unit_Test_Utils::get_private_property_value()`.


v2.0.1 - 2021-08-17
-------------------

+ Add behat `@given` step definition to install LifterLMS add-ons.


v2.0.0 - 2021-07-20
-------------------

+ Add wp-cli testing via behat.


v1.13.0 - 2020-11-04
--------------------

+ Added methods for mocking `WP_Screen`: `llms_tests_mock_current_screen( $id )` & `llms_tests_reset_current_screen()`.
+ Fixed an issue encountered during asset registration assertions when the `$wp_styles` or `$wp_scripts` global had not yet been instantiated.


v1.12.2 - 2020-05-13
--------------------

+ Fix error encountered when using `llms_setcookie()`.


v1.12.1 - 2020-05-05
--------------------

+ Disable `WP_DEBUG` in new docker environments.
+ Don't enable `WP_SCRIPT_DEBUG` in new docker environments.
+ Automatically update the WP core and run WP db updates when starting new docker environments.


v1.12.0 - 2020-05-04
--------------------

+ Updated the `llms-env down` command to include removal of volumes.
+ Remove call to `llms-env rm` when using `llms-env reset` since it's redundant after calling `llms-env down`.
+ Added the `llms-env stop` command to allow stopping containers without removal.
+ Added option `-a --all` to the `llms-env ps` command to allow listing the status of stopped containers.


v1.11.0 - 2020-04-22
--------------------

+ Added utility function `LLMS_Unit_Test_Util::get_private_property_value()`.


v1.10.0 - 2020-04-08
--------------------

+ Added assertions for testing against LifterLMS notices added via `llms_add_notice()`.


v1.9.0 - 2020-04-01
-------------------

+ Added `llms-env`, a set of tools and configurations for manager a simple Docker service. Useful for e2e testing.


v1.8.0 - 2020-01-29
-------------------

+ Added assertions for determining if assets are registered and/or enqueued with the WP asset dependency classes.


v1.7.3 - 2019-12-19
-------------------

+ Fix issue causing `plugin` script subcommand from being able to properly download and unzip plugins loaded from an arbitrary zip file URL on the web.


v1.7.2 - 2019-12-09
-------------------

+ Unset mocked cookies `$_COOKIE` superglobal when unsetting mock cookies.


v1.7.1 - 2019-12-09
-------------------

+ Also set the `$_COOKIE` superglobal when setting mock cookies.


v1.7.0 - 2019-12-09
-------------------

+ Add `LLMS_Tests_Cookie` class to mock and test cookies set by `llms_setcookie()`.


v1.6.2 - 2019-11-11
-------------------

+ Allow usage of `LLMS_Unit_Test_Util::call_method()` on static class methods.


v1.6.1 - 2019-11-04
-------------------

+ Create plugin directory reference with `getcwd()`.


v1.6.0 - 2019-10-11
-------------------

+ Added method to automate a LifterLMS quiz for a given user.


v1.5.0 - 2019-10-01
-------------------

+ Added string assertion methods


v1.4.0 - 2019-03-13
-------------------

+ added order factory


v1.3.0 - 2019-03-12
-------------------

+ Added output assertion unit test case methods.
+ Separated unit test methods into traits.


v1.2.0 - 2019-01-25
-------------------

+ Load add-on framework functions early with core framework functions
+ Recursively load framework functions from subdirectories

v1.3.0 - 2019-07-22
-------------------

+ Added exception test cases.


v1.4.0 - 2019-08-09
-------------------

+ Added additional WP_Error assertions.
