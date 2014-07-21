<?php

class Unitest {

	/**
	* A property should exist in class or object.
	*/
	final public function shouldHaveProperty ($testableObject, $property) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Not an object
		if (!is_object($testableObject)) {
			return $this->fail();

		// Test all given properties
		} else {
			foreach ($arguments as $argument) {
				if (!property_exists($testableObject, $argument)) {
					return $this->fail();
				}
			}	
		}

		return $this->pass();
	}

}

?>