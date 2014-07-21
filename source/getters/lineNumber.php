<?php

class Unitest {

	/**
	* Line number of the file where this class is defined in
	*/
	final public function lineNumber () {
		$ref = new ReflectionClass($this);
		return $ref->getStartLine();
	}

}

?>