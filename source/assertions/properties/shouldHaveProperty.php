<?php

class Unitest {

	/**
	* A property should exist in class or object.
	*/
	final public function shouldHaveProperty ($testableObjectOrClass, $property) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Test all given properties
		foreach ($arguments as $argument) {
			if (!property_exists($testableObjectOrClass, $argument)) {
				return $this->fail();
			}
		}

		return $this->pass();
	}

}

?>