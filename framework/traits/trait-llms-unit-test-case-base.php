<?php
/**
 * Mock Request methods
 * @since 1.5.0
 * @version 1.8.0
 */

include_once 'trait-llms-unit-test-mock-requests.php';

/**
 * LLMS_Unit_Test_Case_Base trait.
 *
 * @since 1.5.0
 * @since 1.7.0 Add `$cookies` property providing access to the instance of `LLMS_Tests_Cookies` class.
 * @since 1.7.2 Clear LifterLMS notices and reset `$_SERVER['REQUEST_URI']` global.
 * @since 1.8.0 Added asset assertions.
 */
trait LLMS_Unit_Test_Case_Base {

	use LLMS_Unit_Test_Mock_Http;
	use LLMS_Unit_Test_Assertions_String;
	use LLMS_Unit_Test_Assertions_Notices;
	use LLMS_Unit_Test_Assertions_Assets;
	use LLMS_Unit_Test_Assertions_Output;
	use LLMS_Unit_Test_Assertions_WP_Error;
	use LLMS_Unit_Test_Mock_Requests;

	/**
	 * @var LLMS_Tests_Cookies
	 */
	protected $cookies;

	/**
	 * @var LLMS_Unit_Test_Factory
	 */
	protected $factory;

	/**
	 * Setup the test case.
	 *
	 * @since 1.6.0
	 * @since 1.7.0 Initailize the `$cookies` property.
	 *
	 * @return void
	 */
	public function setUp() {

		parent::setUp();
		$this->cookies = LLMS_Tests_Cookies::instance();
		$this->factory = new LLMS_Unit_Test_Factory();

	}

	/**
	 * Take a quiz for a student and get a desired grade
	 *
	 * @since 1.5.0
	 *
	 * @param int $quiz_id WP Post ID of the Quiz.
	 * @param int $student_id WP Used ID of the student.
	 * @param int $grade Desired grade.
	 *                   Do the math in the test, this can't make the grade happen if it's not possible.
	 *                   EG: a quiz with 5 questions CANNOT get a 75%!
	 *
	 * @return LLMS_Quiz_Attempt
	 */
	public function take_quiz( $quiz_id, $student_id, $grade = 100 ) {

		$quiz = llms_get_post( $quiz_id );
		$student = llms_get_student( $student_id );

		$attempt = LLMS_Quiz_Attempt::init( $quiz_id, $quiz->get( 'lesson_id' ), $student_id )->start();

		$questions_count = $attempt->get_count( 'gradeable_questions' );
		$points_per_question = ( 100 / $questions_count );
		$to_be_correct = $grade / $points_per_question;

		$i = 1;
		while ( $attempt->get_next_question() ) {

			$question_id = $attempt->get_next_question();

			$question = llms_get_post( $question_id );
			$correct = $question->get_correct_choice();
			// select the correct answer
			if ( $i <= $to_be_correct ) {

				$selected = $correct;

			// select a random incorrect answer
			} else {

				// filter all correct choices out of the array of choices
				$options = array_filter( $question->get_choices(), function( $choice ) {
					return ( ! $choice->is_correct() );
				} );

				// rekey
				$options = array_values( $options );

				// select a random incorrect answer
				$selected = array( $options[ rand( 0, count( $options ) - 1 ) ]->get( 'id' ) );

			}

			$attempt->answer_question( $question_id, $selected );

			$i++;

		}

		$attempt->end();

		return $attempt;

	}

	/**
	 * Teardown the test.
	 *
	 * @since 1.5.0
	 * @since 1.7.0 Unset all cookies set by LLMS_Tests_Cookies and reset the expected response of all cookie sets to `true`.
	 * @since 1.7.2 Clear LifterLMS notices and reset `$_SERVER['REQUEST_URI']` global.
	 *
	 * @return void
	 */
	public function tearDown() {

		parent::tearDown();

		// Reset mocked data.
		llms_tests_reset_current_time();

		// Unset all mocked cookies.
		$this->cookies->unset_all();

		// Reset the expected cookie setter response.
		$this->cookies->expect_success();

		// Clear all LifterLMS notices.
		llms_clear_notices();

		// Clearing REQUEST_URI is necessary after running tests that utilize $this->go_to().
		$_SERVER['REQUEST_URI'] = '';

	}

}
