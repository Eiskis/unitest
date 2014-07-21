<?php

class Unitest {

	/**
	* Object or class should be of any class that extends a specific class or classes.
	*
	* Can be passed multiple parent target classes.
	*
	* Fails if passed non-objects or no objects.
	*/
	final public function shouldExtendClass ($testableObject, $targetClass) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Not an object
		if (!is_object($testableObject)) {
			return $this->fail();

		// Test for wrong class
		} else {
			foreach ($arguments as $argument) {
				if (!is_subclass_of($testableObject, $argument)) {
					return $this->fail();
				}
			}	
		}

		return $this->pass();
	}

}

?>