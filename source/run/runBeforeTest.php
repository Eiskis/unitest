<?php

class Unitest {

	/**
	* When a singe test is about to run
	*/
	final private function runBeforeTest ($method) {
		$arguments = func_get_args();
		$this->execute('beforeTest', $arguments);
		return $this;
	}

}

?>