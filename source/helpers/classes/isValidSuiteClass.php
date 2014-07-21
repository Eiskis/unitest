<?php

class Unitest {

	/**
	* Validate a suite class
	*/
	final private function isValidSuiteClass ($class) {
		$ref = new ReflectionClass($class);
		if ($class === $this->baseClass() or $ref->isSubclassOf($this->baseClass())) {
			return true;
		}
		return false;
	}

}

?>