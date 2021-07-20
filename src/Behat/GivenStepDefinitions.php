<?php
/**
 * @Given step definition trait file
 *
 * @package LifterLMS/Tests/Behat
 *
 * @since 2.0.0
 * @version 2.0.0
 */
namespace LifterLMS\Tests\Behat;

/**
 * Defines @Given step definitions for the FeatureContext class
 *
 * @since 2.0.0
 */
trait GivenStepDefinitions {

	/**
	 * @Given a WP install(ation) with the LifterLMS plugin
	 *
	 * @since 2.0.0
	 */
	public function given_a_wp_install_with_the_lifterlms_plugin() {

		$this->install_wp();

		// Install and activate the LifterLMS Core.
		$this->proc( 'wp plugin install lifterlms --activate' )->run_check();

		// Symlink the current project folder into the WP folder as a plugin.
		$project_dir = realpath( self::get_vendor_dir() . '/../' );
		$plugin_dir  = $this->variables['RUN_DIR'] . '/wp-content/plugins';
		$this->ensure_dir_exists( $plugin_dir );
		$this->proc( "ln -s {$project_dir} {$plugin_dir}/lifterlms-cli" )->run_check();

		// Activate the CLI plugin.
		$this->proc( 'wp plugin activate lifterlms-cli' )->run_check();

	}

}
