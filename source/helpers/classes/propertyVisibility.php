<?php

class Unitest {

	/**
	* Get the visibility of a property of any object or class
	*/
	final private function _propertyVisibility ($classOrObject, $propertyName) {
		if (property_exists($classOrObject, $propertyName)) {
			$ref = new ReflectionProperty($classOrObject, $propertyName);
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