<?php

class Unitest {

	/**
	* Find out which variables a method is expecing
	*/
	final private function methodParameterNames ($method) {
		$results = array();
		$ref = new ReflectionMethod($this, $method);
		foreach ($ref->getParameters() as $parameter) {
			$results[] = $parameter->name;
		}
		return $results;
	}

}

?>