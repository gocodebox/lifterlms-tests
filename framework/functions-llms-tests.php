<?php
/**
 * Plug llms_current_time() to allow mocking of the current time via the $llms_tests_mock_time global
 * @param    string       $type   Type of time to retrieve. Accepts 'mysql', 'timestamp', or PHP date format string (e.g. 'Y-m-d').
 * @param    int|bool     $gmt    Optional. Whether to use GMT timezone. Default false.
 * @return   int|string           Integer if $type is 'timestamp', string otherwise.
 * @since    1.2.0
 * @version  1.2.0
 */
function llms_current_time( $type, $gmt = 0 ) {
	global $llms_tests_mock_time;
	if ( ! empty( $llms_tests_mock_time ) ) {

		switch ( $type ) {
			case 'mysql':
				return date( 'Y-m-d H:i:s', $llms_tests_mock_time );
			case 'timestamp':
				return $llms_tests_mock_time;
			default:
				return date( $type, $llms_tests_mock_time );
		}

	}
	return current_time( $type, $gmt );
}

/**
 * Set the mocked current time
 * @param    mixed     $time  date time string parsable by date()
 * @return   void
 * @since    1.2.0
 * @version  1.2.0
 */
function llms_tests_mock_current_time( $time ) {
	global $llms_tests_mock_time;
	$llms_tests_mock_time = strtotime( $time );
}

/**
 * Reset current time after mocking it
 * @return   void
 * @since    1.2.0
 * @version  1.2.0
 */
function llms_tests_reset_current_time() {
	global $llms_tests_mock_time;
	$llms_tests_mock_time = null;
}
