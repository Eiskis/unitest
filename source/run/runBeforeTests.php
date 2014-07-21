<?php

class Unitest {

	/**
	* When a suite is about to run
	*/
	final private function runBeforeTests () {
		$arguments = func_get_args();
		$this->execute('beforeTests', $arguments);
		return $this;
	}

}

?>