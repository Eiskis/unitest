<?php

class Unitest {

	/**
	* A method should exist in class or object.
	*/
	final protected function shouldHaveMethod ($objectOrClass, $method) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Test all given methods
		foreach ($arguments as $argument) {
			if (!method_exists($objectOrClass, $argument)) {
				return $this->fail();
			}
		}

		return $this->pass();
	}

}

?>