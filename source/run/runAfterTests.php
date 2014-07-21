<?php

class Unitest {

	/**
	* When a suite has run tests
	*/
	final private function runAfterTests () {
		$arguments = func_get_args();
		$this->execute('afterTests', $arguments);
		return $this;
	}

}

?>