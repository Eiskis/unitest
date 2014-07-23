<?php

class Unitest {

	/**
	* Validate a suite class
	*/
	final private function _isValidSuiteClass ($class) {
		$ref = new ReflectionClass($class);
		if ($class === $this->_baseClass or $ref->isSubclassOf($this->_baseClass)) {
			return true;
		}
		return false;
	}

}

?>