<?php

class Unitest {

	/**
	* See what visibility a property has
	*/
	final private function propertyVisibility ($subject, $propertyName) {
		if (property_exists($subject, $propertyName)) {
			$ref = new ReflectionProperty($subject, $propertyName);
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