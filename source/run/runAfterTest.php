<?php

class Unitest {

	/**
	* When a singe test has been run
	*/
	final private function _runAfterTest ($method) {
		$arguments = func_get_args();
		$this->_execute('afterTest', $arguments);
		return $this;
	}

}

?>