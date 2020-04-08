LifterLMS Tests Changelog
=========================

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
