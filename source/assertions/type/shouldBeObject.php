<?php

class Unitest {

	/**
	* Value's type should be object
	*/
	final protected function shouldBeObject ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_object($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>