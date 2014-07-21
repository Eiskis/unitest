<?php

class Unitest {

	/**
	* Which line method is defined in within its class file
	*/
	final private function methodLineNumber ($method) {
		$ref = new ReflectionMethod($this, $method);
		return $ref->getStartLine();
	}

}

?>