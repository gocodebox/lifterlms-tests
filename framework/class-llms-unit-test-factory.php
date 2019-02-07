<?php
/**
 * Factory for making LifterLMS data.
 */
class LLMS_Unit_Test_Factory extends WP_UnitTest_Factory {

	/**
	 * LLMS_Unit_Test_Factory_For_Course
	 *
	 * @var obj
	 */
	public $course;

	/**
	 * LLMS_Unit_Test_Factory_For_Instructor
	 *
	 * @var obj
	 */
	public $instructor;

	/**
	 * LLMS_Unit_Test_Factory_For_Membership
	 *
	 * @var obj
	 */
	public $membership;

	/**
	 * LLMS_Unit_Test_Factory_For_Student
	 *
	 * @var obj
	 */
	public $student;

	/**
	 * Constructor.
	 */
	public function __construct() {

		parent::__construct();

		$this->course  = new LLMS_Unit_Test_Factory_For_Course( $this );
		$this->instructor = new LLMS_Unit_Test_Factory_For_Instructor( $this );
		$this->membership = new LLMS_Unit_Test_Factory_For_Membership( $this );
		$this->student = new LLMS_Unit_Test_Factory_For_Student( $this );

	}

}
