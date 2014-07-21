<?php

class Unitest {

	/**
	* A method with the visibility "protected" should exist in class or object.
	*/
	final public function shouldHaveProtectedMethod ($testableObjectOrClass, $method) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Test all given methods
		foreach ($arguments as $argument) {
			if (!method_exists($testableObjectOrClass, $argument)) {
				return $this->fail();
			} else if ($this->methodVisibility($testableObjectOrClass, $argument) !== 'protected') {
				return $this->fail();
			}
		}

		return $this->pass();
	}

}

?>