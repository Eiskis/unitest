<?php

class Unitest {

	/**
	* A method with the visibility "public" should exist in class or object.
	*/
	final public function shouldHavePublicMethod ($testableObject, $method) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Not an object
		if (!is_object($testableObject)) {
			return $this->fail();

		// Test all given methods
		} else {
			foreach ($arguments as $argument) {
				if (!method_exists($testableObject, $argument)) {
					return $this->fail();
				} else if ($this->methodVisibility($testableObject, $argument) !== 'public') {
					return $this->fail();
				}
			}	
		}

		return $this->pass();
	}

}

?>