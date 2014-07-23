<?php

class Unitest {

	/**
	* Line number of the file where this class or object is defined in
	*/
	final private function _classLineNumber ($classOrObject) {
		$ref = new ReflectionClass($classOrObject);
		return $ref->getStartLine();
	}

}

?>