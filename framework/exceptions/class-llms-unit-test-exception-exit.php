<?php
/**
 * Allow testing functions that call `exit()`
 *
 * Use `$this->expectException( LLMS_Unit_Test_Exception_Exit::class );` before calling the function
 * to test the function that calls `exit()`
 */
class LLMS_Unit_Test_Exception_Exit extends Exception {}
