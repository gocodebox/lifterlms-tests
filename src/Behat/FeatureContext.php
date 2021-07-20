<?php
/**
 * FeatureContext class file
 *
 * @package LifterLMS/Tests/Behat
 *
 * @since 2.0.0
 * @version 2.0.0
 */

namespace LifterLMS\Tests\Behat;

use Behat\Behat\Hook\Scope\AfterFeatureScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeFeatureScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface;

use WP_CLI\Process;
use WP_CLI\Tests\Context\FeatureContext as WP_CLI_FeatureContext;

/**
 * Behat feature test context class
 *
 * This class extends the one that is provided by the wp-cli/wp-cli-tests package.
 * To see a list of all recognized step definitions, run `vendor/bin/behat -dl`.
 *
 * @since 2.0.0
 */
class FeatureContext extends WP_CLI_FeatureContext {

	use GivenStepDefinitions;
	use WhenStepDefinitions;

	/**
	 * The current feature.
	 *
	 * @var FeatureNode|null
	 */
	private static $feature;

	/**
	 * The current scenario.
	 *
	 * @var ScenarioInterface|null
	 */
	private $scenario;

	/**
	 * @BeforeFeature
	 */
	public static function store_feature( BeforeFeatureScope $scope ) {
		self::$feature = $scope->getFeature();
	}

	/**
	 * @BeforeScenario
	 */
	public function store_scenario( BeforeScenarioScope $scope ) {
		$this->scenario = $scope->getScenario();
	}

	/**
	 * @AfterScenario
	 */
	public function forget_scenario( AfterScenarioScope $scope ) {
		$this->scenario = null;
	}

	/**
	 * @AfterFeature
	 */
	public static function forget_feature( AfterFeatureScope $scope ) {
		self::$feature = null;
	}

	/**
	 * Ensure that a requested directory exists and create it recursively as needed.
	 *
	 * @since 2.0.0
	 *
	 * @param string $directory Directory to ensure the existence of.
	 * @throws RuntimeException When the directory cannot be created.
	 * @return void
	 */
	private function ensure_dir_exists( $directory ) {

		$parent = dirname( $directory );
		if ( ! empty( $parent ) && ! is_dir( $parent ) ) {
			$this->ensure_dir_exists( $parent );
		}

		if ( ! is_dir( $directory ) && ! mkdir( $directory ) && ! is_dir( $directory ) ) {
			throw new RuntimeException( "Could not create directory '{$directory}'." );
		}

	}

	public function proc_with_env( $command, $env = array(), $assoc_args = array(), $path = '' ) {

		$proc = parent::proc( $command, $assoc_args, $path );

		$reflector = new \ReflectionObject( $proc );

		$props = array(
			'command' => null,
			'cwd'     => null,
			'env'     => null,
		);
		foreach ( $props as $key => &$val ) {

			$prop = $reflector->getProperty( $key );
			$prop->setAccessible( true );

			if ( 'env' === $key ) {
				$prop->setValue( $proc, array_merge( $prop->getValue( $proc ), $env ) );
			}

			$val = $prop->getValue( $proc );

		}

		return Process::create( ...array_values( $props ) );

	}

	private function get_env() {

		return array(
			'BEHAT_PROJECT_DIR' => $this->variables['PROJECT_DIR'],
			'BEHAT_FEATURE_TITLE'  => self::$feature->getTitle(),
			'BEHAT_SCENARIO_TITLE' => $this->scenario->getTitle(),
		);

	}

}
