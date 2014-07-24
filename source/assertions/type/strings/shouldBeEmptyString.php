<?php

class Unitest {

	/**
	* String value's length should be zero
	*/
	final protected function shouldBeEmptyString ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_string($argument) or strlen($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>