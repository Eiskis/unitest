<?php

class Unitest {

	/**
	* A method should exist in class or object.
	*/
	final protected function shouldHaveMethod ($testableObjectOrClass, $method) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Test all given methods
		foreach ($arguments as $argument) {
			if (!method_exists($testableObjectOrClass, $argument)) {
				return $this->fail();
			}
		}

		return $this->pass();
	}

}

?>