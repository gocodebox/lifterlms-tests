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

###### Output Buffering

+ Assert the output of a function contains a string: `$this->assertOutputContains( $contains, $callable, $args_array );`
+ Assert the output of a function does not contain a string: `$this->assertOutputNotContains( $contains, $callable, $args_array );`
+ Assert the output of a function is empty: `$this->assertOutputEmpty( $callable, $args_array );`
+ Assert the output of a function equals an expectation: `$this->assertOutputEquals( $expected, $callable, $args_array );`

###### `WP_Error`

+ Assert a `WP_Error` code equals an expectation: `$this->assertWPErrorCodeEquals( $code, $wp_err );`
+ Assert an object is a `WP_Error`:  `$this->assertWPError( $wp_err );`

##### Mock `$_GET`, `$_POST`, and `$_REQUEST` data

Add mock `$_GET` data via `$this->mockGetRequest( array( 'var' => 'value' ) );`

Add mock `$_POST` data via `$this->mockPostRequest( array( 'var' => 'value' ) );`

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
