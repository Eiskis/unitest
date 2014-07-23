<?php

class Unitest {

	/**
	* All test methods of this suite
	*/
	final public function tests () {
		$tests = array();

		// All class methods
		foreach (get_class_methods($this) as $method) {

			// Class methods with the correct prefix
			if (substr($method, 0, strlen($this->prefix())) === $this->prefix()) {

				// Prefixed methods that aren't declared in base class
				$ref = new ReflectionMethod($this, $method);
				$class = $ref->getDeclaringClass();
				if ($class->name !== $this->baseClass()) {
					$tests[] = $method;
				}

			}
		}

		return $tests;
	}

}

?>