<?php

class Unitest {

	/**
	* See what visibility a method has
	*/
	final private function methodVisibility ($subject, $methodName) {
		if (method_exists($subject, $methodName)) {
			$ref = new ReflectionMethod($subject, $methodName);
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