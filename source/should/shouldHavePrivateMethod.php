<?php

class Unitest {

	/**
	* A method with the visibility "private" should exist in class or object.
	*/
	final public function shouldHavePrivateMethod ($testableObject, $method) {
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
				} else if ($this->methodVisibility($testableObject, $argument) !== 'private') {
					return $this->fail();
				}
			}	
		}

		return $this->pass();
	}

}

?>