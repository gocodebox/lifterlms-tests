<?php
/**
 * Testing Utilities
 */
class LLMS_Unit_Test_Util {

	/**
	 * Call a method (private or protected)
	 * @param   obj $obj Instantiated class instance
	 * @param   string $name Name of the method to call
	 * @param   array $args arguments to pass to the method
	 * @return  mixed
	 */
	public static function call_method( $obj, $name, array $args = array() ) {

		$method = self::getPrivateMethod( $obj, $name );
		return $method->invokeArgs( $obj, $args );

	}

	/**
	 * Alias of LLMS_Unit_Test_Utilities::get_private_method()
	 * @param   obj $obj Instantiated class instance
	 * @param   string $name Name of the method to call
	 * @return  ReflectionMethod
	 */
	public static function get_protected_method( $obj, $name ) {

		return self::get_private_method( $obj, $name );

	}

	/**
	 * Retrieve a testable private/protected class method
	 * @param   obj $obj Instantiated class instance
	 * @param   string $name Name of the method to call
	 * @return  ReflectionMethod
	 */
	public static function get_private_method( $obj, $name ) {

		$class = new ReflectionClass( $obj );
		$method = $class->getMethod( $name );
		$method->setAccessible( true );
		return $method;

	}

}
