<?php

class Unitest {

	/**
	* A method with the visibility "public" should exist in class or object.
	*/
	final protected function shouldHavePublicMethod ($testableObjectOrClass, $method) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Test all given methods
		foreach ($arguments as $argument) {
			if (!method_exists($testableObjectOrClass, $argument)) {
				return $this->fail();
			} else if ($this->_methodVisibility($testableObjectOrClass, $argument) !== 'public') {
				return $this->fail();
			}
		}

		return $this->pass();
	}

}

?>