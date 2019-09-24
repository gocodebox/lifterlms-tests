<?php
/**
 * Mock Request methods
 * @since 1.5.0
 * @version 1.5.0
 */

include_once 'trait-llms-unit-test-mock-requests.php';

trait LLMS_Unit_Test_Case_Base {

	use LLMS_Unit_Test_Mock_Http;
	use LLMS_Unit_Test_Assertions_Output;
	use LLMS_Unit_Test_Assertions_WP_Error;
	use LLMS_Unit_Test_Mock_Requests;

	/**
	 * Setup the test case.
	 *
	 * @since 1.5.0
	 *
	 * @return void
	 */
	public function setUp() {

		parent::setUp();
		$this->factory = new LLMS_Unit_Test_Factory();

	}

	/**
	 * Teardown the test.
	 *
	 * @since 1.5.0
	 *
	 * @return void
	 */
	public function tearDown() {

		parent::tearDown();
		llms_tests_reset_current_time();

	}

}
