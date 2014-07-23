<?php

class Unitest {

	/**
	* A static property should exist in class.
	*/
	final protected function shouldHaveStaticProperty ($objectOrClass, $property) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Test all given properties
		foreach ($arguments as $argument) {
			if (!property_exists($objectOrClass, $argument)) {
				return $this->fail();
			} else {

				// Use reflection to check property
				$ref = new ReflectionProperty($objectOrClass, $argument);
				if (!$ref->isStatic()) {
					return $this->fail();
				}

				return $this->fail();
			}
		}

		return $this->pass();
	}

}

?>