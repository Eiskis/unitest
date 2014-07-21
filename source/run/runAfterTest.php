<?php

class Unitest {

	/**
	* When a singe test has been run
	*/
	final private function runAfterTest ($method) {
		$arguments = func_get_args();
		$this->execute('afterTest', $arguments);
		return $this;
	}

}

?>