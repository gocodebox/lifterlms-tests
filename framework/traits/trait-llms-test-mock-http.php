<?php
/**
 * Mock HTTP requests made via `wp_remote_request()`.
 *
 * @since 1.5.0
 * @version 1.5.0
 */
trait LLMS_Unit_Test_Mock_Http {

	/**
	 * Request URL to mock.
	 *
	 * @var string
	 */
	protected $_url_to_mock = '';

	/**
	 * Mock HTTP Request Return.
	 *
	 * @var array
	 */
	protected $_mock_return = array();

	/**
	 * Whether or not `$_url_to_mock` should be an exact or fuzzy match.
	 *
	 * @var bool
	 */
	protected $_fuzzy_match = false;

	/**
	 * Setup mock http request data.
	 *
	 * @since 1.5.0
	 *
	 * @param string $url_to_mock The URL to mock.
	 * @param array|obj|WP_Error $mock_return The mock data to respond with.
	 * @return void
	 */
	protected function mock_http_request( $url_to_mock, $mock_return = array(), $fuzzy = false ) {

		$this->_url_to_mock = $url_to_mock;
		$this->_mock_return = $mock_return;
		$this->_fuzzy_match = $fuzzy;

		add_filter( 'pre_http_request', array( $this, '_handle_mock_http_request' ), 10, 3 );

	}

	/**
	 * Mock `wp_remote_request` via the `pre_http_request`
	 *
	 * @since 1.5.0
	 *
	 * @link https://developer.wordpress.org/reference/hooks/pre_http_request/
	 *
	 * @param false|array|WP_Error $ret Whether to preempt the response.
	 * @param array $args HTTP Request args.
	 * @param string $url Request url.
	 * @return false|array|WP_Error
	 */
	public function _handle_mock_http_request( $ret, $args, $url ) {

		// This is our mock url.
		if ( ( $this->_fuzzy_match && false !== strpos( $url, $this->_url_to_mock ) ) || $url === $this->_url_to_mock ) {

			// Return the mock return data.
			$ret = $this->_mock_return;

			// Reset class members.
			$this->_url_to_mock = '';
			$this->_mock_return = array();
			$this->_fuzzy_match = false;

			// Remove the filter.
			remove_filter( 'pre_http_request', array( $this, '_handle_mock_http_request' ), 10 );

		}

		return $ret;

	}

}
