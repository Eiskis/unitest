<?php

class Unitest {

	/**
	* Validate a suite object
	*/
	final private function _isValidSuite ($case) {
		return isset($case) and is_object($case) and (
			get_class($case) === $this->_baseClass or
			is_subclass_of($case, $this->_baseClass)
		);
	}

}

?>