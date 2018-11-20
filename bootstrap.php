<?php
class LLMS_Tests_Bootstrap {

	/**
	 * __FILE__ reference, should be defined in the extending class
	 * @var [type]
	 */
	public $file = __FILE__;

	/**
	 * Plugin Directory Path
	 * @var  string
	 */
	public $plugin_dir;

	/**
	 * Main PHP File for the plugin
	 * @var string
	 */
	public $plugin_main;

	/**
	 * Name of the testing suite
	 * @var string
	 */
	public $suite_name = 'LifterLMS';

	/**
	 * Tests Directory Path
	 * @var  string
	 */
	public $tests_dir;

	/**
	 * Determines if the LifterLMS core should be loaded
	 * @var bool
	 */
	public $use_core = true;

	/**
	 * WP Tests Directory Path
	 * @var  string
	 */
	public $wp_tests_dir;

	/**
	 * Constructor
	 * @since    [version]
	 * @version  [version]
	 */
	public function __construct() {

		echo 'Welcome to the ' . $this->suite_name . ' Test Suite' . PHP_EOL . PHP_EOL . PHP_EOL;

		ini_set( 'display_errors','on' );
		error_reporting( E_ALL );

		// Ensure server variable is set for WP email functions.
		if ( ! isset( $_SERVER['SERVER_NAME'] ) ) {
			$_SERVER['SERVER_NAME'] = 'localhost';
		}

		$this->tests_dir    = dirname( $this->file );
		$this->plugin_dir   = dirname( $this->tests_dir );
		$this->wp_tests_dir = getenv( 'WP_TESTS_DIR' ) ? getenv( 'WP_TESTS_DIR' ) : 'tmp/tests/wordpress-tests-lib';

		// load test function so tests_add_filter() is available
		require_once $this->wp_tests_dir . '/includes/functions.php';

		// Load the plugin.
		tests_add_filter( 'muplugins_loaded', array( $this, 'load' ) );

		// Install the plugin.
		tests_add_filter( 'setup_theme', array( $this, 'install' ) );

		// Load the WP testing environment.
		require_once( $this->wp_tests_dir . '/includes/bootstrap.php' );

		// Activate LifterLMS Core (if it exists)
		if ( $this->use_core && file_exists( WP_PLUGIN_DIR . '/lifterlms' ) ) {
			define( 'LLMS_USE_PHP_SESSIONS', true );
			activate_plugin( WP_PLUGIN_DIR . '/lifterlms/lifterlms.php' );
		}

		// Load any includes.
		$this->includes();

	}

	/**
	 * Load test suite files/includes
	 * @return   void
	 * @since    [version]
	 * @version  [version]
	 */
	public function includes() {

		$files = array_merge(
			glob( dirname( __FILE__ ) . '/framework/*.php' ),
			glob( dirname( __FILE__ ) . '/framework/factory/*.php' )
		);

		if ( file_exists( $this->tests_dir . '/framework' ) ) {
			$files = array_merge( $files, glob( $this->tests_dir . '/framework/*.php' ) );
		}

		foreach ( $files as $file ) {
			require_once $file;
		}

	}

	/**
	 * Install the plugin
	 * @return   void
	 * @since    [version]
	 * @version  [version]
	 */
	public function install() {

		$this->uninstall();

		echo 'Installing '. $this->suite_name .'...' . PHP_EOL;

	}

	/**
	 * Load the plugin
	 * @return  void
	 * @since   [version]
	 * @version [version]
	 */
	public function load() {

		if ( $this->plugin_main ) {
			require_once( $this->plugin_dir . '/' . $this->plugin_main );
		}

	}

	/**
	 * Uninstall the plugin.
	 * @return  [type]
	 * @since   [version]
	 * @version [version]
	 */
	public function uninstall() {

		// Clean existing install first.
		if ( file_exists( $this->plugin_dir . '/uninstall.php' ) ) {

			echo 'Removing '. $this->suite_name .'...' . PHP_EOL;

			define( 'WP_UNINSTALL_PLUGIN', true );
			require_once $this->plugin_dir . '/uninstall.php';

		}

	}

}
