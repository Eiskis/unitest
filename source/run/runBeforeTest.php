<?php

class Unitest {

	/**
	* When a singe test is about to run
	*/
	final private function _runBeforeTest ($method) {
		$arguments = func_get_args();
		$this->_execute('beforeTest', $arguments);
		return $this;
	}

}

?>