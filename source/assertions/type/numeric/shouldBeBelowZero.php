<?php

class Unitest {

	/**
	* Numeric value should be below zero
	*/
	final protected function shouldBeBelowZero ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_numeric($argument) or $argument >= 0) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>