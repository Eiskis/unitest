<?php

class Unitest {

	/**
	* Object or class should be of any class that extends a specific class or classes.
	*
	* Can be passed multiple parent target classes.
	*/
	final public function shouldExtendClass ($testableObjectOrClass, $targetClass) {
		$arguments = func_get_args();
		array_shift($arguments);

		// Test for wrong class
		foreach ($arguments as $argument) {
			if (!is_subclass_of($testableObjectOrClass, $argument)) {
				return $this->fail();
			}
		}

		return $this->pass();
	}

}

?>