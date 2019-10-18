<?php

class LLMS_Unit_Test_Factory_For_Membership extends WP_UnitTest_Factory_For_Post {

	public function __construct( $factory = null ) {
		parent::__construct( $factory );
		$this->default_generation_definitions = array(
			'post_status'  => 'publish',
			'post_title'   => new WP_UnitTest_Generator_Sequence( 'Membership title %s' ),
			'post_content' => new WP_UnitTest_Generator_Sequence( 'Membership content %s' ),
			'post_excerpt' => new WP_UnitTest_Generator_Sequence( 'Membership excerpt %s' ),
			'post_type' => 'llms_membership'
		);
	}

	public function get_object_by_id( $post_id ) {
		return llms_get_post( $post_id );
	}

}
