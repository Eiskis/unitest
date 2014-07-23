<?php

class Unitest {

	/**
	* A property with the visibility "protected" should exist in class or object.
	*/
	final protected function shouldHaveProtectedProperty ($testableObjectOrClass, $property) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Test all given properties
		foreach ($arguments as $argument) {
			if (!property_exists($testableObjectOrClass, $argument)) {
				return $this->fail();
			} else if ($this->propertyVisibility($testableObjectOrClass, $argument) !== 'protected') {
				return $this->fail();
			}
		}

		return $this->pass();
	}

}

?>