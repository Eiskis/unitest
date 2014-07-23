<?php

class Unitest {

	/**
	* A property should exist in class or object.
	*/
	final protected function shouldHaveProperty ($objectOrClass, $property) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Test all given properties
		foreach ($arguments as $argument) {
			if (!property_exists($objectOrClass, $argument)) {
				return $this->fail();
			}
		}

		return $this->pass();
	}

}

?>