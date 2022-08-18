LifterLMS Tests
===============

LifterLMS Tests is a project to help bootstrap automated testing in LifterLMS projects.

## Installation

+ Install package: `composer require --dev lifterlms/lifterlms-tests`
+ Create a `phpunit.xml.dist` file. See [example](examples/phpunit.xml.dist).
+ Add a `tests` direcotry: `mkdir tests`
+ Create a bootstrap file in the `tests` directory. see [example](examples/bootstrap.php).
+ Add test classes in `tests/unit-tests`

## Commands

+ Install Testing Suite: `./vendor/bin/llms-tests install <db-name> <db-user> <db-pass> [db-host] [wp-version] [skip-database-creation]`
+ Teardown Testing Suite: `.vendor/bin/llms-tests teardown <db-name> <db-user> <db-pass> [db-host]`
+ Install a Plugin: `./vendor/bin/llms-tests plugin <slug_or_zip_giturl> [version]`
+ Run tests: `./vendor/bin/phpunit`
+ Environment: `./vendor/bin/llms-env <command> [options]`. See `./vendor/bin/llms-env --help` for full documentation.

## Environment

The `llms-env` command provides a simple set of tools helpful in managing a set of Docker containers for use in development and testing of a LifterLMS plugin.

For customization, run `llms-env config` to create the recommended `docker-compose.yml` and `.llmsenv` files in the project root.

The `docker-compose.yml` will automatically mount the root directory into the `wp-content/plugin` directory.

The `.llmsenv` file allows customization of the WordPress username, localhost port, and more. This file is optional and the defaults will be used if any variables are excluded.

After setting up the configuration files run `llms-env up` to create the containers, install, and configure WordPress.

If any additional plugins are required or any other WordPress configurations are required, try creating a composer script that runs the required commands via `wp-cli` on the main PHP service container. For example, add a script in your composer.json:

```json
{
  "scripts": {
    "env-setup": [
      "./vendor/bin/llms-env wp plugin install lifterlms --activate"
    ]
  }
}
```

This can be run to activate the LifterLMS core.

The `llms-env` provides many commands for composing and managing the Docker containers. Run `llms-env --help` for a full list of available commands as well as information on their usage.


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

## Utilities

Utility methods are located in the `LLMS_Unit_Test_Util` class.

Retrieve a private/protected class method:

```php
$method = LLMS_Unit_Test_Util::get_private_method( new MyClass(), 'my_private_method' );
$method = LLMS_Unit_Test_Util::get_protected_method( new MyClass(), 'my_private_method' );
```

Call a private/protected class method for testing:

```php
$result = LLMS_Unit_Test_Util::call_method( new MyClass(), 'my_private_method', array( 'argument_1', 'arg_2', ... ) );
$this->assertTrue( $result );
```

## Functions

Mock the return of `llms_current_time()` by using `llms_tests_mock_current_time( $timestamp_or_date )`

Reset the current time with `llms_tests_reset_current_time()`


## Test Case Methods

Test cases which extend the `LLMS_Unit_Test_Case` class may access utility functiosn built into the test case class.

##### Assertions

Test cases which extend the `LLMS_Unit_Test_Case` class may access utility functiosn built into the test case class.

###### Assets

Assert that assets (scripts or styles) are registered or enqueued (or inversely not registered or not enqueued) with WordPress dependency managements classes.

`$type` is either "script" or "style" and `$handle` is the asset handle used to register/enqueue the script.

+ Assert a script/style is registered: `$this->assertAssetIsRegistered( $type, $handle )`
+ Assert a script/style is not registered: `$this->assertAssetNotRegistered( $type, $handle )`
+ Assert a script/style is enqueued: `$this->assertAssetIsEnqueued( $type, $handle )`
+ Assert a script/style is not enqueued: `$this->assertAssetNotEnqueued( $type, $handle )`

###### Output Buffering

+ Assert the output of a function contains a string: `$this->assertOutputContains( $contains, $callable, $args_array );`
+ Assert the output of a function does not contain a string: `$this->assertOutputNotContains( $contains, $callable, $args_array );`
+ Assert the output of a function is empty: `$this->assertOutputEmpty( $callable, $args_array );`
+ Assert the output of a function equals an expectation: `$this->assertOutputEquals( $expected, $callable, $args_array );`

###### `WP_Error`

+ Assert an object is a `WP_Error`:  `$this->assertWPError( $wp_err );`
+ Assert a `WP_Error` code equals an expectation: `$this->assertWPErrorCodeEquals( $code, $wp_err );`
+ Assert a `WP_Error` message equals an expectation: `$this->assertWPErrorMessageEquals( $message, $wp_err );`
+ Assert a `WP_Error` data equals an expectation: `$this->assertWPErrorDataEquals( $data, $wp_err );`


##### Mock `$_GET`, `$_POST`, and `$_REQUEST` data

Add mock `$_GET` data via `$this->mockGetRequest( array( 'var' => 'value' ) );`

Add mock `$_POST` data via `$this->mockPostRequest( array( 'var' => 'value' ) );`


##### Mock HTTP request made via `wp_remote_request()`.

Before calling `wp_remote_request()` run `$this->mock_http_request( $url, $data, $fuzzy_match )` to setup the desired return of the next `wp_remote_request()`.

When `wp_remote_request()` is run, the mocker will check to see if a mock has been added for the URL, if found, it will short-circuit the HTTP request and return early (before any remote connection is made), returning the value of `$data`. Once the mock is found and returned, it will be removed from the mocker's data. If you wish to mock several consecutive URLs you can call `mock_http_request()` multiple times. The matcher will always return the *first* match. So if you wish to mock the same URL more than once, make sure setup the mocks in the order you expect them to be returned.

You can specify a full or partial URL as the `$url` parameter. If a specifying a partial URL, use `$fuzzy_match = true` to match the URL part.

```php

public function test_mock_https_request() {

  // Mocks a WP REST post creation request.
  $this->mock_http_request( '/wp-json/wp/v2/posts',
    [ 
      'body'     => '{"id":123,"title":"Mock Title",...}',
      'response' => [
        'code' => 201,
      ],
    ], 
    true
  );

  $res = wp_remote_post( 
    rest_url( '/wp-json/wp/v2/posts' ),
    [
      'body' => [
        'title' => 'Mock Title',
      ],
    ],
  );

  $this->assertEquals( 201, wp_remote_retrieve_response_code( $res ) );
  $this->assertEquals( 123, json_decode( wp_remote_retrieve_response_body( $res ) )['id'] );

}


##### Utility Methods

+ Get the output of a function: `$output = $this->get_output( $callable, $args_array );`

## Exceptions

Included exceptions allow easy testing of methods which call `exit()` and `llms_redirect_and_exit()`.

##### LLMS_Unit_Test_Exception_Exit

Test methods which call `exit()`: Call `$this->expectException( LLMS_Unit_Test_Exception_Exit::class );` before calling the function that calls exit.

```php
public function test_example_exit() {
  $this->expectException( LLMS_Unit_Test_Exception_Exit::class );
  example_function_that_exits();
}
```

##### LLMS_Unit_Test_Exception_Redirect

Test methods which call `llms_redirect_and_exit()`:

```php
public function test_my_redirect_and_exit() {
  $this->expectException( LLMS_Unit_Test_Exception_Redirect::class );
  $this->expectExceptionMessage( 'https://lifterlms.com [302] YES' );
  llms_redirect_and_exit( 'https://lifterlms.com' );
}
```

The exceptions will cause PHP execution to cease. To run additional tests after the exception is encountered add a try/catch block:

```php
public function test_my_redirect_and_exit() {
  $this->expectException( LLMS_Unit_Test_Exception_Redirect::class );
  $this->expectExceptionMessage( 'https://lifterlms.com [302] YES' );
  try {
    llms_redirect_and_exit( 'https://lifterlms.com' );
  } catch( LLMS_Unit_Test_Exception_Redirect $exception ) {
    // Any additional assertions can be added here.
    $this->assertTrue( ... );
    throw $exception;
  }
}
```


## Factories

Test cases which extend the `LLMS_Unit_Test_Case` class may access factories built off the WP Unit Tests Factories: `WP_UnitTest_Factory_For_Post` and `WP_UnitTest_Factory_For_User`

##### Course Post Factory

Access the factory: `$this->factory->course`

Create a course and retrieve the course ID: `$course_id = $this->factory->course->create();`

Create a course and retrieve LLMS_Course object: `$course = $this->factory->course->create_and_get();`

Create a many courses: `$courses = $this->factory->course->create_many( 5 );`

Specify the number of sections, lessons, quizzes, and questions:

```php
$args = array(
  'sections' => 2, // 2 sections in the course
  'lessons' => 5, // 5 lessons per section
  'quizzes' => 1, // 1 quiz per section (will always be the last lesson in the section)
  'questions' => 5, // 5 questions per quiz
);
$course_id = $this->factory->course->create( $args );
$course = $this->factory->course->create_and_get( $args );
```

##### Membership Post Factory

Access the factory: `$this->factory->membership`

Create a membership and retrieve the membership ID: `$membership_id = $this->factory->membership->create();`

Create a membership and retrieve LLMS_Membership object: `$membership = $this->factory->membership->create_and_get();`

Create a many memberships: `$memberships = $this->factory->membership->create_many( 5 );`


##### Order Post Factory

Access the factory: `$this->factory->order`

Create an order and retrieve the order ID: `$order_id = $this->factory->order->create();`

Create an order and retrieve LLMS_Order object: `$order = $this->factory->order->create_and_get();`

Create a many orders: `$orders = $this->factory->order->create_many( 5 );`

Create an order and record a transaction for it LLMS_Order: `$order = $this->factory->order->create_and_pay();`


##### Student User Factory

Access the factory: `$this->factory->student`

Create a student and retrieve the student ID: `$student_id = $this->factory->student->create();`

Create a student and retrieve LLMS_Student object: `$student = $this->factory->student->create_and_get();`

Create a many students: `$students = $this->factory->student->create_many( 5 );`

Create a student(s) and enroll into a course/membership:

```php
$course_id = $this->factory->course->create();
// single student
$student_id = $this->factory->student->create_and_enroll( $coursed_id );
// multiple students
$student_ids = $this->factory->student->create_and_enroll_many( 5, $coursed_id );
```


##### Instructor User Factory

Access the factory: `$this->factory->instructor`

Create a instructor and retrieve the instructor ID: `$instructor_id = $this->factory->instructor->create();`

Create a instructor and retrieve LLMS_Instructor object: `$instructor = $this->factory->instructor->create_and_get();`


## Cookies

Test methods and functions that set cookies via `llms_setcookie` using the `LLMS_Tests_Cookies` class.

Access the class: `$this->cookies`.

##### Set a cookie

```php
$this->cookies->set( $name, $value, ... )
```

##### Retrieve set cookie(s)

```php
$this->cookies->set( 'name', 'value', 0, ... );

// Retrieve all cookies
$cookies = $this->cookies->get_all();
var_dump( $cookies );
// array(
//   'name' => array(
//      'value'   => 'value',
//      'expires' => 0,
//      ...
//   ),
// )
//

// Retrieve a single cookie.
$cookie = $this->cookies->get( 'name' );
var_dump( $cookie );
// array(
//    'value'   => 'value',
//    'expires' => 0,
//    ...
//   ),
```

##### Mock the expected response of llms_setcookie()

Mock a success response:

```php
$this->cookies->expect_success();
$this->assertTrue( llms_setcookie( 'name', 'val' ) );
```

In the testing suite `llms_setcookie()` will always respond `true` so it's not necessary to call `expect_success()` unless you previously call `expect_error()` in the same test.


Mock an error response:

```php
$this->cookies->expect_error();
$this->assertFalse( llms_setcookie( 'name', 'val' ) );
```


##### Clear set cookie(s)

Clear all cookies:

```php
$this->cookies->unset_all()
var_dump( $this->cookies->get_all() );
// array()
```

Clear a single cookie by name:

```php
llms_setcookie( 'name', 'val' );
$this->cookies->unset( 'name' );
var_dump( $this->cookies->get( 'name' ) );
// null
```
