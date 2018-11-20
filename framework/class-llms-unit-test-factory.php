<?php
/**
 * Factory for making LifterLMS data.
 * @since   [version]
 * @version [version]
 */
class LLMS_Unit_Test_Factory extends WP_UnitTest_Factory {

	/**
	 * LLMS_Unit_Test_Factory_For_Student
	 * @var obj
	 */
	public $student;

	/**
	 * Constructor.
	 *
	 * @since   [version]
	 * @version [version]
	 */
	public function __construct() {

		parent::__construct();

		$this->course  = new LLMS_Unit_Test_Factory_For_Course( $this );
		$this->student = new LLMS_Unit_Test_Factory_For_Student( $this );

	}

}
