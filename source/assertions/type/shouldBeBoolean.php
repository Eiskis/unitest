<?php

class Unitest {

	/**
	* Value's type should be boolean
	*/
	final protected function shouldBeBoolean ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_bool($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>