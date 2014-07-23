<?php

class Unitest {

	/**
	* A property with the visibility "public" should exist in class or object.
	*/
	final protected function shouldHavePublicProperty ($testableObjectOrClass, $property) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Test all given properties
		foreach ($arguments as $argument) {
			if (!property_exists($testableObjectOrClass, $argument)) {
				return $this->fail();
			} else if ($this->propertyVisibility($testableObjectOrClass, $argument) !== 'public') {
				return $this->fail();
			}
		}

		return $this->pass();
	}

}

?>