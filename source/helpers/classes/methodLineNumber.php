<?php

class Unitest {

	/**
	* Get the line number where method is defined in within its class file
	*/
	final private function methodLineNumber ($classOrObject, $method) {
		$ref = new ReflectionMethod($classOrObject, $method);
		return $ref->getStartLine();
	}

}

?>