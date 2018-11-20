<?php

class LLMS_Unit_Test_Factory_For_Student extends WP_UnitTest_Factory_For_User {

	/**
	 * Create a new Student Factory.
	 *
	 * This is essentially the WP Core User Factory except it creates users with the "Student" role
	 * and Returns an LLMS_Student object with gets
	 *
	 * @param   obj $factory  Global Factory.
	 * @since   [version]
	 * @version [version]
	 */
	public function __construct( $factory = null ) {
		parent::__construct( $factory );
		$this->default_generation_definitions = array(
			'user_login' => new WP_UnitTest_Generator_Sequence( 'Student %s' ),
			'user_pass'  => 'password',
			'user_email' => new WP_UnitTest_Generator_Sequence( 'student_%s@example.org' ),
			'role' => 'student',
		);
	}

	/**
	 * Retrieve student by ID
	 *
	 * @param   int   $user_id WP User ID.
	 * @return  obj
	 * @since   [version]
	 * @version [version]
	 */
	public function get_object_by_id( $user_id ) {
		return new LLMS_Student( $user_id );
	}

}
