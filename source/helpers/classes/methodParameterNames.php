<?php

class Unitest {

	/**
	* List the names of the function parameters a method is expecing
	*/
	final private function _methodParameterNames ($classOrObject, $method) {
		if (method_exists($classOrObject, $method)) {
			$results = array();
			$ref = new ReflectionMethod($classOrObject, $method);
			foreach ($ref->getParameters() as $parameter) {
				$results[] = $parameter->name;
			}
			return $results;
		}
		return null;
	}

}

?>