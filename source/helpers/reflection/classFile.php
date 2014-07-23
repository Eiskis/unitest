<?php

class Unitest {

	/**
	* File where this class or object is defined in
	*/
	final private function classFile ($classOrObject) {
		$ref = new ReflectionClass($classOrObject);
		return $ref->getFileName();
	}

}

?>