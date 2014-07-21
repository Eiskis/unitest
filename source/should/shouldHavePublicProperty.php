<?php

class Unitest {

	/**
	* A property with the visibility "public" should exist in class or object.
	*/
	final public function shouldHavePublicProperty ($testableObject, $property) {
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
				} else if ($this->propertyVisibility($testableObject, $argument) !== 'public') {
					return $this->fail();
				}
			}	
		}

		return $this->pass();
	}

}

?>