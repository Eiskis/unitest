<?php

class Unitest {

	/**
	* Validate a suite object
	*/
	final private function isValidSuite ($case) {
		return isset($case) and is_object($case) and (
			get_class($case) === $this->baseClass() or
			is_subclass_of($case, $this->baseClass())
		);
	}

}

?>