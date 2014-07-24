<?php

class Unitest {

	/**
	* Value's type should be string
	*/
	final protected function shouldBeString ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_string($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>