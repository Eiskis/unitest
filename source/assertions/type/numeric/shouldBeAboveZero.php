<?php

class Unitest {

	/**
	* Numeric value should be above zero
	*/
	final protected function shouldBeAboveZero ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_numeric($argument) or $argument <= 0) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>