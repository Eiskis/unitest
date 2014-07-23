<?php

class Unitest {

	/**
	* A static method should exist in class.
	*/
	final protected function shouldHaveStaticMethod ($objectOrClass, $method) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Test all given methods
		foreach ($arguments as $argument) {
			if (!method_exists($objectOrClass, $argument)) {
				return $this->fail();
			} else {

				// Use reflection to check method
				$ref = new ReflectionMethod($objectOrClass, $argument);
				if (!$ref->isStatic()) {
					return $this->fail();
				}

			}
		}

		return $this->pass();
	}

}

?>