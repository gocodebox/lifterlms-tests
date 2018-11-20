<?php
/**
 * Base test case for all tests
 */
class LLMS_Unit_Test_Case extends WP_UnitTestCase {

	/**
	 * Setup the test case.
	 *
	 * @since   [version]
	 * @version [version]
	 */
	public function setUp() {

		parent::setUp();
		$this->factory = new LLMS_Unit_Test_Factory();

	}


}
