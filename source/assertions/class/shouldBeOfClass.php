<?php

class Unitest {

	/**
	* Should be of a specific class.
	*
	* Fails if passed non-objects or no objects.
	*/
	final protected function shouldBeOfClass ($object, $class) {

		// Not an object
		if (!is_object($object)) {
			return $this->fail();

		// Wrong class
		} else if (get_class($object) !== $class) {
			return $this->fail();
		}

		return $this->pass();
	}

}

?>