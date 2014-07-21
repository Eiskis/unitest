<?php

class Unitest {

	/**
	* Test can fail with false, or a message (any value but null or true)
	*/
	final protected function fail () {
		$arguments = func_get_args();
		$count = func_num_args();

		// Empty value is returned as false, otherwise returned as message
		if ($count === 1) {
			return !empty($arguments[0]) ? $arguments[0] : false;

		// Multiple values provided, fail with those as message
		} else if ($count > 1) {
			return $arguments;
		}

		// Default to false
		return false;
	}

}

?>