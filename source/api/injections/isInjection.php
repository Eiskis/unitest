<?php

class Unitest {

	/**
	* Find out if injection is available
	*/
	final public function isInjection ($name) {
		$arguments = func_get_args();
		$arguments = $this->_flattenArray($arguments);
		$injections = $this->injections();

		// Fail if one of the equested injections is not available
		foreach ($arguments as $argument) {
			if (!array_key_exists($argument, $injections)) {
				return false;
			}
		}

		return true;
	}

}

?>