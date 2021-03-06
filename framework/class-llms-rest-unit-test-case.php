<?php
/**
 * Base test case for all tests
 *
 * @since [version]
 */
class LLMS_REST_Unit_Test_Case extends WP_UnitTestCase {

	use LLMS_Unit_Test_Case_Base {
		setUp as baseSetUp;
		tearDown as baseTearDown;
	}
	use LLMS_Unit_Test_Assertions_REST_Responses;

	/**
	 * Route being tested by the class
	 *
	 * EG: /llms/v1/courses
	 *
	 * @var string
	 */
	protected $route = '';

	/**
	 * Setup the test case
	 *
	 * @since [version]
	 *
	 * @return void
	 */
	public function setUp() {

		$this::baseSetUp();
		do_action( 'rest_api_init' );
		$this->server = rest_get_server();

	}

	/**
	 * Unset the server.
	 *
	 * @since [version]
	 *
	 * @return  void
	 */
	public function tearDown() {

		$this::baseTearDown();

		global $wp_rest_server;
		unset( $this->server );

		$wp_rest_server = null;

	}

	/**
	 * Preform a mock WP_REST_Request
	 *
	 * @since [version]
	 *
	 * @param string $method Request method.
	 * @param string $route  Request route, eg: '/llms/v1/courses'.
	 * @param array  $body   Optional request body.
	 * @param array  $query  Optional query arguments.
	 * @return WP_REST_Response.
	 */
	protected function perform_mock_request( $method, $route, $body = array(), $query = array() ) {

		$request = new WP_REST_Request( $method, $route );
		if ( $body ) {
			$request->set_body_params( $body );
		}
		if( $query ) {
			$request->set_query_params( $query );
		}
		return $this->server->dispatch( $request );

	}

}
