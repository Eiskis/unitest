<?php

class Unitest {

	/**
	* Should be of a specific class.
	*
	* Fails if passed non-objects or no objects.
	*/
	final protected function shouldBeOfClass ($testableObject, $targetClass) {

		// Not an object
		if (!is_object($testableObject)) {
			return $this->fail();

		// Wrong class
		} else if (get_class($testableObject) !== $targetClass) {
			return $this->fail();
		}

		return $this->pass();
	}

}

?>