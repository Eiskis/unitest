<?php

class Unitest {

	/**
	* Value's type should be integer
	*/
	final protected function shouldBeInteger ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_int($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>