<?php

class Unitest {

	/**
	* All assertion methods of this suite (methods beginning with should)
	*/
	final public function assertions () {
		$assertions = array();
		$ref = new ReflectionClass($this);

		// All methods beginning with the prefix 'should'
		foreach ($ref->getMethods() as $method) {
			if (substr($method->name, 0, strlen($this->_assertionMethodPrefix)) === $this->_assertionMethodPrefix) {
				$assertions[] = $method->name;
			}
		}

		return $assertions;
	}

}

?>