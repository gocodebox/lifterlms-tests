<?php
/**
 * Base test case for all tests
 * @since   1.0.0
 * @version 1.3.0
 */
class LLMS_Unit_Test_Case extends WP_UnitTestCase {

	use LLMS_Unit_Test_Assertions_Output;
	use LLMS_Unit_Test_Assertions_WP_Error;
	use LLMS_Unit_Test_Mock_Requests;

	/**
	 * Setup the test case.
	 *
	 * @return  void
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function setUp() {

		parent::setUp();
		$this->factory = new LLMS_Unit_Test_Factory();

	}

	/**
	 * Teardown the test.
	 *
	 * @return  void
	 * @since   1.2.0
	 * @version 1.2.0
	 */
	public function tearDown() {

		parent::tearDown();
		llms_tests_reset_current_time();

	}

}
