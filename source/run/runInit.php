<?php

class Unitest {

	/**
	* When instance is created
	*/
	final private function runInit () {
		$arguments = func_get_args();
		$this->execute('init', $arguments);
		return $this;
	}

}

?>