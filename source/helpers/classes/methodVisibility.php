<?php

class Unitest {

	/**
	* Get the visibility of a method of any object or class
	*/
	final private function _methodVisibility ($classOrObject, $method) {
		if (method_exists($classOrObject, $method)) {
			$ref = new ReflectionMethod($classOrObject, $method);
			if ($ref->isPrivate()) {
				return 'private';
			} else if ($ref->isProtected()) {
				return 'protected';
			}
			return 'public';
		}
		return null;
	}

}

?>