<?php

class Unitest {

	/**
	* Numeric value should be exactly zero
	*/
	final protected function shouldBeZero ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_numeric($argument) or $argument < 0 or $argument > 0) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>