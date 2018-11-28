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

	/**
	 * Setup Get data to mock post and request data
	 *
	 * @param    array      $vars  mock get data
	 * @return   void
	 * @since    [version]
	 * @version  [version]
	 */
	protected function mockGetRequest( $vars = array() ) {
		$this->mockRequest( 'GET', $vars );
	}

	/**
	 * Setup Post data to mock post and request data
	 *
	 * @param    array      $vars  mock post data
	 * @return   void
	 * @since    [version]
	 * @version  [version]
	 */
	protected function mockPostRequest( $vars = array() ) {
		$this->mockRequest( 'POST', $vars );
	}

	/**
	 * Setup reuqest data to mock post/get and request data
	 *
	 * @param    array      $vars  mock request data
	 * @return   void
	 * @since    [version]
	 * @version  [version]
	 */
	private function mockRequest( $method, $vars = array() ) {
		putenv( 'REQUEST_METHOD=' . $method );
		if ( 'POST' === $method ) {
			$_POST = $vars;
		} elseif ( 'GET' === $method ) {
			$_GET = $vars;
		}
		$_REQUEST = $vars;
	}

}
