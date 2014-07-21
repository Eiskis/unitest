<?php

class Unitest {

	/**
	* Get or set an injectable value
	*/
	final public function injection ($name) {

		// Set
		$arguments = func_get_args();
		if (func_num_args() > 1) {
			return $this->execute('inject', $arguments);
		}

		// Get own injections, bubble
		$injections = $this->injections();
		if (array_key_exists($name, $injections)) {
			return $injections[$name];
		}

		// Missing injection
		throw new Exception('Missing injection "'.$name.'".');
		return $this;
	}

}

?>