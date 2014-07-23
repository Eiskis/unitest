<?php

class Unitest {

	/**
	* When a suite has run tests
	*/
	final private function _runAfterTests () {
		$arguments = func_get_args();
		$this->_execute('afterTests', $arguments);
		return $this;
	}

}

?>