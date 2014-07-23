<?php

class Unitest {

	/**
	* Child suites
	*/
	final public function children () {

		// Set
		$arguments = func_get_args();
		if (!empty($arguments)) {
			return $this->_execute('child', $arguments);
		}

		// Get
		return $this->_propertyChildren;
	}

}

?>