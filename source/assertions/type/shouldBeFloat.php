<?php

class Unitest {

	/**
	* Value's type should be float
	*/
	final protected function shouldBeFloat ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_float($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>