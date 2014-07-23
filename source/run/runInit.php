<?php

class Unitest {

	/**
	* When instance is created
	*/
	final private function _runInit () {
		$arguments = func_get_args();
		$this->_execute('init', $arguments);
		return $this;
	}

}

?>