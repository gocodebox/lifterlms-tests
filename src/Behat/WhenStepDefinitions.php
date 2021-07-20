<?php
/**
 * @When step definition trait file
 *
 * @package LifterLMS/Tests/Behat
 *
 * @since 2.0.0
 * @version 2.0.0
 */
namespace LifterLMS\Tests\Behat;

/**
 * Defines @When step definitions for the FeatureContext class
 *
 * @since 2.0.0
 */
trait WhenStepDefinitions {

	/**
	 * @When /^I (run|try) the WP-CLI command `([^`]+)`$/
	 *
	 * @since 2.0.0
	 */
	public function when_i_run_the_wp_cli_command( $mode, $command ) {

		$run_coverage = getenv( 'RUN_CODE_COVERAGE' );
		if ( in_array( $run_coverage, array( true, 'true', 1, '1' ), true ) ) {
			$command = "{$command} --require={PROJECT_DIR}/vendor/lifterlms/lifterlms-tests/utils/wp-cli-code-coverage.php";
		}

		$cmd          = $this->replace_variables( $command );
		$this->result = $this->wpcli_tests_invoke_proc( $this->proc_with_env( $cmd, $this->get_env() ), $mode );
		list( $this->result->stdout, $this->email_sends ) = $this->wpcli_tests_capture_email_sends( $this->result->stdout );

	}

}
