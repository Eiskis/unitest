<?php

class Unitest {

	/**
	* Run own method with arguments
	*/
	final private function _execute ($method, $arguments) {
		if (method_exists($this, $method)) {

			// Get errors as exceptions
			set_error_handler('__UnitestHandleError');

			// Run method
			$result = call_user_func_array(array($this, $method), (is_array($arguments) ? $arguments : array($arguments)));

			// Restore previous error handler
			restore_error_handler();

			return $result;
		}
		// return null;
	}

}

?>